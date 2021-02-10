<?php

/**
 * Pre-Qualification / Elegibility for Credit Cards using Experian
 */
class MWHPreQual
{
    const THRESHOLD = 30;
    /*
     * This translates Experian Card Types into Our WordPress Cart Categories.
     *
     * The format is
     * 'ExperianCategory' = 'wordpress-category'
     *
     * If you a new category to type_of_card then you have to add a translation
     * record to this array and a category under Credit Cards in WordPress.
     */
    const CARD_TYPE_TRANSLATION = [
        'AllCards' => 'all-credit-cards',
        'Rewards' => 'rewards',
        'Travel' => 'travel',
        'Airline' => 'airline',
        'BT' => 'balance-transfer'
    ];
    const CARD_TYPES = array(
        'Amex_Cashback_Everyday',
        'Amex_Platinum_Cashback',
        'American_Express_Preferred_Rewards_Gold',
        'British_Airways_American_Express_Premium_Plus',
        'Amex_Rewards_Card',
        'Amex_Nectar_Card',
        'Amex_Platinum_Card',
        'Amex_Marriott_Bonvoy_Card',
        'Amex_Green_Card',
        'BA_Amex_Card',
        'MS_TRANSFER_PLUS',
        'MS_Shopping_Plus',
        'MS_RewardPlus'
    );
    protected const EXPERIAN_OAUTH_TOKEN_KEY = 'tmfmwh_experian_oauth_token';
    protected const SECONDS_UNTIL_OAUTH_TOKEN_EXPIRES = 1200;

    private $prequal_form = [];
    private $access_token = NULL;

    /**
     * @todo Is this property every used? I think it might be $this->status but
     * that is only set once and never called. - Cal
     */
    private $staus = 'Unknown';

    /**
     * Build a pre-qual application.
     *
     * @todo rename. As far as I can tell, this does not validate any of the
     * data. It only prepares the payload to submit.
     */
    public function CheckApplication() {
        $this->prequal_form = [];
        $this->prequal_form['callType'] = 'Prequalification';
        $this->prequal_form['clientReference'] = uniqid();

        $telephone_number = sanitize_text_field( $_POST['phone_number'] );
        $marital_status =  sanitize_text_field( $_POST['marital_status'] );

        if (empty( $marital_status ) || $marital_status === 'Please select') {
            $marital_status = '';
        }

        $building = $this->buildingNameOrNumber(
            sanitize_text_field( $_POST['address'] )
        );

        $applicant = [
            'title' => sanitize_text_field( $_POST['your_title'] ),
            'firstName' => sanitize_text_field( $_POST['first_name'] ),
            'lastName' => sanitize_text_field( $_POST['last_name'] ),
            'dateOfBirth' => sanitize_text_field( $_POST['date_of_birth'] ),
            'currentAddress' => array(
                'address' => array(
                    'buildingNumber' => $building['number'],
                    'buildingName' => $building['name'],
                    'flat' => sanitize_text_field( $_POST['flat'] ),
                    'street' => sanitize_text_field( $_POST['street'] ),
                    'town' =>  sanitize_text_field( $_POST['town'] ),
                    'postCode' => sanitize_text_field( $_POST['postcode'] )
                ),
                'yearsAtAddress'=> intval( $_POST['length_at_address']  )
            ),
            'emailAddress' => sanitize_text_field( $_POST['email_address'] ),
            'ResidentialStatus' => sanitize_text_field( $_POST['residential_status'] ),
            'EmploymentStatus' => sanitize_text_field( $_POST['employment_status'] ),
            'Income' => $this->convertToNumber( $_POST['annual_income'] ),
            'NumberOfDependants' => sanitize_text_field( $_POST['number_of_dependents'] ),
            'ChildCareCost' => sanitize_text_field( $_POST['child_care'] ),
            'MonthlyAccomodationCost' => $this->convertToNumber( $_POST['rent_or_mortgage_cost'] ),
            'OtherIncome' => $this->convertToNumber( $_POST['other_income'] )
        ];


        /*
         * If we have a previous address, add it it to the payload
         */
        if (
            isset($_POST['prev_postcode']) &&
            ! empty($_POST['prev_postcode'])
        ) {
            $building = $this->buildingNameOrNumber(
                sanitize_text_field( $_POST['prev_address'] )
            );

            $applicant['PreviousAddress'] = [
                'address' => [
                    'buildingNumber' => $building['number'],
                    'buildingName' => $building['name'],
                    'flat' => sanitize_text_field( $_POST['prev_flat'] ),
                    'street' => sanitize_text_field( $_POST['prev_street'] ),
                    'town' =>  sanitize_text_field( $_POST['prev_town'] ),
                    'postCode' => sanitize_text_field( $_POST['prev_postcode'] )
                ],
                'yearsAtAddress'=> sanitize_text_field( $_POST['prev_length_at_address'] )

            ];
        }

        /*
         * Phone is not a required field in the payload. If a payload is
         * submitted with an empty phone, it will return an error. Therefore,
         * we only add it in if we have a value.
         */
        if (! empty($telephone_number) ) {
            $applicant['telephone_number'] = $telephone_number;
        }

        /*
         * Marital Status is an optional field but if provided it must contain
         * a valid value. 'Please Select' and empty are not valid values. We
         * filter it above and set it to empty if it is 'Please Select'. This
         * keeps it from being added into the payload if it's empty.
         */
        if (! empty($marital_status) ) {
            $applicant['MaritalStatus'] = $marital_status;
        }

        $this->prequal_form['applicant'] = $applicant;

        $this->prequal_form['CardDetails'] = [
            'ProductType' => sanitize_text_field($_POST['type_of_card']),
            'ProductCodes' => self::CARD_TYPES
        ];

        $this->prequal_form['metaData'] = [
            'ipAddress' => $_SERVER['REMOTE_ADDR'],
            'userAgent' => $_SERVER['HTTP_USER_AGENT'],
            'deviceType' => wp_is_mobile() ? 'Mobile' : 'Desktop',
            'trafficSourceCode' => "MyWalletHero",
            'browser' => '',
            'browserVersion' => ''
        ];
        $this->prequal_form = json_encode( $this->prequal_form );
        return true;
    }

    /*
     * This is the main function. It fetches a token and then calls
     * getExperianScores() to build and submit the form.
     */
    public function SubmitPreQual() : StdClass
    {
        $result = array();
        $this->getExperianAuth();
        $result = $this->getExperianScores();
        return $result;
    }

    /**
     * @todo rip put curl and use guzzle
     * @todo move credentials out of options and put in .env file for theme?
     * @todo error handling
     */
    private function getExperianAuth() {
        $token = get_transient( self::EXPERIAN_OAUTH_TOKEN_KEY );

        if ( $token ) {
            $this->access_token = $token;
            return $token;
        }

        $client_id = get_option( 'tmfmwh_experian_client_id' );
        $client_secret = get_option( 'tmfmwh_experian_client_secret' );
        $username = get_option( 'tmfmwh_experian_username' );
        $password = get_option( 'tmfmwh_experian_password' );
        $oauth_url = get_option( 'tmfmwh_experian_oauth_url' );

        $httpHeader = array(
            'Connection: keep-alive',
            'Content-Type: application/json',
            'client_id: ' . $client_id,
            'client_secret: ' . $client_secret
        );

        $body = '{
            "username":"' . $username . '",
            "password":"' . $password . '"
        }';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $oauth_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Motley Fool - My Wallet Hero');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        $response = curl_exec($ch);
        $responseInfo = curl_getinfo($ch);
        $http_code = $responseInfo['http_code'];

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);
        $json = json_decode( $body );

        set_transient(
            self::EXPERIAN_OAUTH_TOKEN_KEY,
             $json->access_token,
             self::SECONDS_UNTIL_OAUTH_TOKEN_EXPIRES
        );

        $this->access_token = $json->access_token;
        return $json->access_token;
    }

    private function getExperianScores() : StdClass
    {
        $scores_url = get_option( 'tmfmwh_experian_scores_url' );

        $return = new StdClass();
        $return->products = [];
        $return->errors = [];

        $httpHeader = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->access_token,
            'callType: Prequalification',
            'Connection: keep-alive'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $scores_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Motley Fool - My Wallet Hero');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->prequal_form);

        $response = curl_exec($ch);
        $responseInfo = curl_getinfo($ch);
        $http_code = $responseInfo['http_code'];

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = json_decode( substr($response, $header_size) );
        curl_close($ch);
        $this->status = $body->cardsResult->status;
        /*
         * Handle FAIL
         */
        if( 'Validation failed' == $body->message ){
            foreach( $body->errors as $err ){
                $return->errors[] = $err[0];
            }
            return $return;
        }
        /*
         * Handle SUCCESS BUT NO RECORDS
         */
        // echo "<pre>";
        // print_r($this->status);
        // die();
        if($this->status == "NoMatch") {
            /* No Match on the Users Data */
            $return->errors[] = "Unfortunately, we're unable to provide you with any cards that you may be eligible for. Please double check that the information you provided is correct and try again.";
            return $return;
        } else {
            $return->products  = $body->cardsResult->products;
            if( NULL === $return->products || empty($return->products) ){
                /* No Products Returned */
                return $return;
            } else {
                $return->products  = $body->cardsResult->products;
                $return->products = $this->filterProducts($return->products);
                /*
                 * Gather the additional information that is needed to display the
                 * cards.
                 */
                foreach( $return->products as $prod ) {
                    $prod->productDetails = $this->getProductDetails(
                         $prod->productCode,$_POST['type_of_card'],$body->hdReference
                    );
                }
                $return->products = $this->sortProducts($return->products,$_POST['type_of_card']);
                return $return;
            }
        }
    }
    /* function to get the post details and meta data */
    private function getProductDetails( $productCode = '', $type_of_card = '', $hdReference = '') {
        $details = array();
        global $wpdb;
        $details['postID'] = $wpdb->get_var("SELECT `post_id` FROM `" . $wpdb->postmeta . "` WHERE `meta_key`='product_id' AND `meta_value` LIKE '%" . $productCode . "%' LIMIT 1");
        $post = get_post( $details['postID'], ARRAY_A );

        $details = array_merge( $details, $post );

        $meta = get_post_meta( $details['postID'] );

        $details["product_code"] = $productCode;
        $details["type_of_card"] = $type_of_card;
        $details["hd_reference"] = $hdReference;

        $details['summary'] = $meta['summary'][0] ?? '';
        $details['overall'] = $meta['overall'][0] ?? '';
        $details['url'] = $meta['url'][0] ?? '';
        $details['bottom_line'] = $meta['bottom_line'][0] ?? '';
        $details['representative_ex'] = $meta['representative_ex'][0] ?? '';
        $details['subtitle'] = $meta['subtitle'][0] ?? '';
        $details['bottom_line'] = $meta['bottom_line'][0] ?? '';

        $details['company'] = $meta['company'][0] ?? '';
        $details['regular_apr'] = $meta['regular_apr'][0] ?? '';
        $details['annual_fee'] = $meta['annual_fee'][0] ?? '';
        $details['other_apr'] = $meta['other_apr'][0] ?? '';
        $details['what_we_like'] = $meta['what_we_like'][0] ?? '';
        $details['perks_score'] = $meta['perks_score'][0] ?? ''; #key score
        $details['fees_score'] = $meta['fees_score'][0] ?? ''; #key score
        $details['apr_score'] = $meta['apr_score'][0] ?? ''; #key score
        $details['meta_overall'] = $meta['meta_overall'][0] ?? ''; #stars

        $details["featured_img_medium"] = get_the_post_thumbnail( $details['postID'], 'medium' );
        $details["post_permalink"] = get_permalink( $details['postID'] );
        $details['categories'] = $this->getCategories((int)$details['postID']);

        return $details;
    }

    /**
     * Retrieve the categories that have been assigned to this card and filter
     * them down into an easy-to-use array.
     */
    private function getCategories( int $postID ) : array
    {
        $returnValue = [];
        foreach ( get_the_terms( $postID, 'prod_category' ) as $thisCategory) {
            $returnValue[$thisCategory->slug] = $thisCategory->name;
        }
        return $returnValue;
    }

    private function convertToNumber( $s = '' ) {
        $n = intval( str_replace( ',', '', $s ) );
        return $n;
    }

    /**
     * Parse the address line and determine if it is a building number or
     * building name.
     */
    private function buildingNameOrNumber(string $value) : array
    {
        $returnValue = [];
        /*
         * Do we have a building NUMBER or NAME? We only need 1.
         */
        if (is_numeric($value)) {
            $returnValue['name'] = '';
            $returnValue['number'] = (int)$value;
        } else {
            $returnValue['name'] = $value;
            $returnValue['number'] = '';
        }

        return $returnValue;
    }

   /*
    * Filter the array to only show cards that the applicant has a 30% chance
    * of better of getting.
    */
    private function filterProducts(array $products) : array
    {
        foreach( $products as $ix=>$p ){
            if( $p->likelihood < self::THRESHOLD ) {
                unset($products[$ix]);
            }
        }
        return $products;
    }

    private function sortProducts( array $products, string $experianCategory = '' ) : array
    {

        /*
         * If a primary category is passed in, float all cards tagged with that
         * category those to the top.
         */
        if (! empty($experianCategory)) {
            $categoryProducts = [];
            $nonCategoryProducts = [];

            /*
             * Create 2 arrays, category and non-category
             */

            foreach($products as $thisProduct) {
                if (
                    isset(
                        $thisProduct->productDetails['categories'][self::CARD_TYPE_TRANSLATION[$experianCategory]]
                    )
                ) {
                    $thisProduct->productDetails['categoryCard'] = true;
                    $thisProduct->productDetails['searchedCategory'] = $thisProduct->productDetails['categories'][self::CARD_TYPE_TRANSLATION[$experianCategory]];
                    $categoryProducts[] = $thisProduct;
                } else {
                    $thisProduct->productDetails['categoryCard'] = false;
                    $thisProduct->productDetails['searchedCategory'] = $thisProduct->productDetails['categories'][self::CARD_TYPE_TRANSLATION[$experianCategory]];
                    $nonCategoryProducts[] = $thisProduct;
                }

            }

            /*
             * Sort them individually and then package them up to return.
             */
            usort( $categoryProducts, function( $a, $b ) {
                return $a->likelihood < $b->likelihood;
            });
            usort( $nonCategoryProducts, function( $a, $b ) {
                return $a->likelihood < $b->likelihood;
            });

            $products = array_merge($categoryProducts, $nonCategoryProducts);
        } else {
            /*
             * If no sort is passed in, just sort by likelyhood
             */
            usort( $products, function( $a, $b ) {
                return $a->likelihood < $b->likelihood;
            });
        }
        /*
         * Otherwise, sort the cards by likelyhood
         */

        return $products;
    }

} // class MWHPreQual

function tmfmwh_experian_tracking($postdata){
    $url = "https://clicktrackingpreprod.hdd2.co.uk/v1/ClickTrackingService.svc/xml/TrackClick";
    $login_user = "Motley";
    $login_pass = "bV848FSyKv!";

    $type = $postdata["type_of_card"];

    $payload = '<ClickTrackingInput xmlns="http://HDDecisions.co.uk/services" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
            <HDIdentifier>0</HDIdentifier>
            <VerticalType>Cards</VerticalType>
            <ProductType>'.$_GET["type_of_card"].'</ProductType>
            <ProductIdentifier>'.$_GET["product_code"].'</ProductIdentifier>
            <DateOfClick>'.date("Y-m-d\TG:i:s").'</DateOfClick>
            <HDReference>'.$_GET["hd_reference"].'</HDReference>
            </ClickTrackingInput>';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $login_user . ":" . $login_pass);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $return = curl_exec($ch);

    curl_close($ch);

    wp_redirect($_GET["url"],301);
    die();
}

add_action('wp_ajax_tmfmwh_experian_tracking', 'tmfmwh_experian_tracking');
add_action('wp_ajax_nopriv_tmfmwh_experian_tracking', 'tmfmwh_experian_tracking');
/*
 * Support functions
 */
function tmfmwh_admin_experian() {
    $action = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : '';
    if( 'save_config' == $action ) {
        update_option( 'tmfmwh_experian_client_id', sanitize_text_field( $_POST['experian_client_id'] ), FALSE );
        update_option( 'tmfmwh_experian_client_secret', sanitize_text_field( $_POST['experian_client_secret'] ), FALSE );
        update_option( 'tmfmwh_experian_username', sanitize_text_field( $_POST['experian_username'] ), FALSE );
        update_option( 'tmfmwh_experian_password', sanitize_text_field( $_POST['experian_password'] ), FALSE );
        update_option( 'tmfmwh_experian_oauth_url', sanitize_text_field( $_POST['experian_oauth_url'] ), FALSE );
        update_option( 'tmfmwh_experian_scores_url', sanitize_text_field( $_POST['experian_scores_url'] ), FALSE );
        $prequal_enabled = '';
        if( '1' == $_POST['experian_prequal_enabled'] ) {
            $prequal_enabled = '1';
        }
        update_option( 'tmfmwh_experian_prequal_enabled', $prequal_enabled );
    }

    $experian_client_id = get_option('tmfmwh_experian_client_id');
    $experian_client_secret = get_option('tmfmwh_experian_client_secret');
    $experian_username = get_option('tmfmwh_experian_username');
    $experian_password = get_option('tmfmwh_experian_password');
    $experian_oauth_url = get_option('tmfmwh_experian_oauth_url');
    $experian_username = get_option('tmfmwh_experian_username');
    $experian_scores_url = get_option('tmfmwh_experian_scores_url');
    $experian_prequal_enabled = get_option('tmfmwh_experian_prequal_enabled');
    $check_enabled = '';
    if( '1' == $experian_prequal_enabled ) {
        $check_enabled = 'checked="checked"';
    }
    ?>
    <h1>Experian</h1>
    <h3>Pre-Qualification / Eligibility Configuration</h3>
    <form action="<?php echo esc_url( admin_url( 'options-general.php?page=experian_prequal&action=save_config' ) ); ?>" method="post">
    <div>
        Enable Pre-Qual Check: <input type="checkbox" name="experian_prequal_enabled" value="1" <?php echo $check_enabled; ?> /><br>
        Client ID: <input type="text" name="experian_client_id" value="<?php echo esc_attr( $experian_client_id ); ?>" /><br>
        Client Secret: <input type="text" name="experian_client_secret" value="<?php echo esc_attr( $experian_client_secret ); ?>" /><br>
        Username: <input type="text" name="experian_username" value="<?php echo esc_attr( $experian_username ); ?>" /><br>
        Password: <input type="text" name="experian_password" value="<?php echo esc_attr( $experian_password ); ?>" /><br>
        OAuth URL: <input type="text" name="experian_oauth_url" value="<?php echo esc_attr( $experian_oauth_url ); ?>" /><br>
        Scores URL: <input type="text" name="experian_scores_url" value="<?php echo esc_attr( $experian_scores_url ); ?>" /><br>
        <button type="submit">Save Config</button>
    </div>
    </form>
    <?php
}

function tmfmwh_admin_experian_menu() {
    add_submenu_page( 'options-general.php', 'Experian', 'Experian', 'manage_options', 'experian_prequal', 'tmfmwh_admin_experian' );
}
add_action( 'admin_menu', 'tmfmwh_admin_experian_menu' );

function tmfmwh_experian_prequal_form( $atts ) {

    $a = shortcode_atts(array(
        'campaign' => 'homepage',
        'button' => 'Subscribe'
    ), $atts);

    $ecap = new MWHEcap();
    ob_start();
?>
<section class="ecap">
  <div class="wrap">
    <form action="<?php echo site_url('/subscribe'); ?>" method="post" id="mwh-ecap-form">
      <div class="fieldset">
        <input type="email" value="" name="email_address" id="email_address" required placeholder="Enter Your Email Address"><button type="submit"><?php echo esc_html( $a['button'] ); ?></button>
      </div>
      <footer class="ecap__footer">
        <input type="checkbox" value="1" name="legal_agreed" id="legal_agreed" required="required">
        <label class="checkbox__label" for="legal_agreed">
          <span class="checkbox__icon">
            <?php echo file_get_contents( get_template_directory_uri() . '/assets/images/icons/checkmark.svg'); ?>
          </span>
        </label>
        <legend class="checkbox__legend"><?php echo $ecap->get_legal_message(); ?></legend>
      </footer>
      <input type="hidden" name="campaign_name" value="<?php echo esc_attr( $a['campaign'] ) ?>" />
    </form>
  </div>
</section>
<?php

    return ob_get_clean();
}
add_shortcode( 'mwh_experian_prequal', 'tmfmwh_experian_prequal_form' );


/*
 * JavaScript version of the email capture form
*/
function tmfmwh_experian_prequal_form_js( $atts ) {
    $a = shortcode_atts(array(
        'campaign' => 'homepage',
        'button' => 'Subscribe',
        'id' => NULL
    ), $atts);

    if( NULL !== $a['id'] ) {
        $meta = get_post_meta( $a['id'] );
        $a['campaign'] = $meta['campaign_name'][0];
        $a['button'] = $meta['button_text'][0];
    }

    $ecap = new MWHEcap();
    ob_start();
?>
<section class="ecap">
  <div class="wrap" id="ecap-<?php echo esc_attr( $a['campaign'] ); ?>">
    <?php
    if( is_home() || is_front_page() ) {
        $title = get_option('homepage_ecap_title');
        $text = get_option('homepage_ecap_text');
        if( '' != $title ) { ?>
            <h3 class="optin__title"><?php echo esc_html( $title ); ?></h3>
        <?php }
        if( '' != $text ){ ?>
            <span class="optin__intro"><?php echo apply_filters('the_content', $text); ?></span>
        <?php }
    }
    ?>
      <form action="#" method="post" id="mwh-ecap-form">
      <div class="fieldset">
        <input type="email" value="" name="email_address" id="email_address" required placeholder="Enter Your Email Address"><button type="submit"><?php echo esc_html( $a['button'] ); ?></button>
      </div>
      <footer class="ecap__footer">
        <input type="checkbox" value="1" name="legal_agreed" id="legal_agreed" required="required">
        <label class="checkbox__label" for="legal_agreed">
          <span class="checkbox__icon">
            <?php echo file_get_contents( get_template_directory_uri() . '/assets/images/icons/checkmark.svg'); ?>
          </span>
        </label>
        <legend class="checkbox__legend"><?php echo $ecap->get_legal_message(); ?></legend>
      </footer>
      <input type="hidden" id="campaign_name" name="campaign_name" value="<?php echo esc_attr( $a['campaign'] ) ?>" />
      <input type="hidden" id="ecap_form_id" name="ecap_form_id" value="<?php echo esc_attr( $a['id'] ) ?>" />
    </form>
  </div>
</section>
<script type="text/javascript">
$(document).ready(function(){

$('body').on('submit', '#mwh-ecap-form', function(e){
    var campaign = $('#campaign_name').val();
    var email = $('#email_address').val();
    var legal = $('#legal_agreed').val();
    var id = $('#ecap_form_id').val();
    formData = {
        "action": "mwh_ecap_form",
        "campaign_name": campaign,
        "email_address": email,
        "legal_agreed": legal,
        "ecap_form_id": id,
        "nonce_data": '<?php echo wp_create_nonce( "mwh-ecap-ajax-nonce" ); ?>'
    };
    $.ajax({
        type: "post",
        dataType: "json",
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        data: formData,
        success: function(data){
            result = data.result;
            title = data.title;
            msg = data.message;
            campaign_div = '#ecap-' + campaign;
            if( 1 == data.success ) {
                $( campaign_div ).html( '<h3 class="optin__title">' + title + '</h3>' );
                $( campaign_div ).append( '<p>' + msg + '</p>' );
                if( '' != data.redirect_url ) {
                    $( campaign_div ).append( '<p>You will be redirected in <span id="countdown-timer">5</span></p>' );
                    countdown( data.redirect_url );
                }
            } else {
                $( campaign_div ).append( '<p>' + msg + '</p>' );
            }
        }
    });
    return false;
});
});

var seconds = 5;

function countdown( redirect_url ) {
    seconds = seconds - 1;
    if (seconds <= 0) {
        window.location = redirect_url;
    } else {
        document.getElementById("countdown-timer").innerHTML = seconds;
        window.setTimeout("countdown('" + redirect_url + "')", 1000);
    }
}

</script>
<?php
        return ob_get_clean();
}
add_shortcode( 'mwh_experian_prequal_js', 'tmfmwh_experian_prequalre_form_js' );

function tmfmwh_experian_prequal_submit_js() {
    $ecap = new MWHEcap();
    $email = ''; // initialize $email
    $emailErr = null; // initialize $emailErr
    $campaign = 'homepage';

    // check for incoming email
    if( isset( $_POST['email_address'] ) && '' != $_POST['email_address'] ) {
        $email = sanitize_email($_POST['email_address']);
        if( '' === $email ) {
            $emailErr = "Oops! It looks like the email address you've tried to register is invalid. Please check the spelling and syntax, then try submitting the form again.";
            // reset $email so we can populate the form
            $email = sanitize_text_field($_POST['email_address']);
        }
    } elseif( isset( $_POST['email_address'] ) ) {
        $emailErr = 'Missing email address.';
    }

    // check if the checkbox was checked
    if( isset( $_POST['email_address'] ) && !isset( $_POST['legal_agreed'] ) ) {
        $emailErr = 'You did not accept the legal terms.';
    }

    // check if the checkbox was checked
    if( isset( $_POST['campaign_name'] ) ) {
        $campaign = sanitize_text_field($_POST['campaign_name']);
    }

    $ecap_form_id = NULL;
    if( '' != $_POST['ecap_form_id'] ) {
        $ecap_form_id = intval( $_POST['ecap_form_id'] );
    }

    // if everything looks OK then add the email
    if( '' != $email && null === $emailErr ) {
        $emailErr = $ecap->add_email( $email, $campaign, $ecap_form_id );
    }

    if( '' == $email || null !== $emailErr ) {
        echo '{"success": 0, "result": 0, "message": "' . $emailErr . '"}';
        wp_die();
    } else {
        echo '{"success": 1, "result": ' . $ecap->get_mailchimp_result() . ', "title": "' . esc_attr( $ecap->get_response_title() ) . '", "message": "' . esc_attr( $ecap->get_response_message() ) . '", "redirect_url": "' . esc_attr( $ecap->get_redirect_url() ) . '"}';
        wp_die();
    }

}

/*
 * These need to go somewhere...but not here.
 */
add_action( 'wp_ajax_nopriv_mwh_experian_prequal_form', 'tmfmwh_experian_prequal_submit_js' );
add_action( 'wp_ajax_mwh_experian_prequal_form', 'tmfmwh_experian_prequal_submit_js' );

function tmfmwh_experian_prequal_form_homepage( $atts ) {
    $homepage_id = intval( get_option( 'ecap_form_homepage_id' ) );

    ob_start();
    if( 0 === $homepage_id ) {
        echo do_shortcode( '[mwh_ecap_form_js campaign="freemailsignup" button="Subscribe"]' );
    } else {
        echo do_shortcode( '[mwh_ecap_form_js id="' . $homepage_id . '"]' );
    }
    return ob_get_clean();
}

add_shortcode( 'mwh_experian_prequal_form_homepage', 'tmfmwh_experian_prequal_form_homepage' );

