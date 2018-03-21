<%@ Page Title="" Language="C#" MasterPageFile="~/account/account.master" AutoEventWireup="true" CodeFile="media.aspx.cs" Inherits="account_media" %>
<asp:Content ID="Content1" ContentPlaceHolderID="style" Runat="Server">
<style>
			#main {overflow:visible;}
		.mtd {margin-left: auto; margin-right: auto; width: 970px;background-color: #ffffff; padding: 10px 5px 10px 5px;font-family:Arial;}
		.heading{font-size:14px;font-weight:bold;}
		.sub-menu {font-size:14px;font-weight:bold;margin: 10px 0px 10px 0px;}
		.item1 {background-color:#ffffff;border:1px solid #c9c9c9;}
		.item2 {background-color:#c0c0c0;border:1px solid #c9c9c9;}
		.margintop10 {margin-top:10px;}
		.frmWin {background-color:#ffffff;padding:25px;}
		.frm {background-color:#ffffff;padding:25px;}
		.items {position:relative;}
		.item {vertical-align:top;width:400px;display:inline-block;padding:7px;margin-right:15px;margin-bottom:20px;-moz-box-shadow:0px 0px 5px 2px rgba(119, 119, 119, 0.5);-webkit-box-shadow:0px 0px 5px 2px rgba(119, 119, 119, 0.5);box-shadow:0px 0px 5px 2px rgba(119, 119, 119, 0.5);}
		label  { position:absolute; top:6px; left:9px;font-weight:normal;font-size:12px;color:#666666;}
		input {font-size: 12px;width: 400px !important;border:1px solid #6d6d6d;padding:7px;}
		textarea {width:650px;height:100px;font-size:16px;}
		 input[type="button"] {width:150px !important;}
		.left {float:left;}.center{text-align:center;}
		.formitem {position:relative;}.top10{margin-top:10px;}.top20{margin-top:20px;}
		.errorsummary {display:none;}
		.errorfield {border-color: #bf284b !important; box-shadow: 0 0 8px #bf284b !important;}
		.clearing {clear:both;width:100%;height:5px;}
		.tabrow {text-align: left;list-style: none;margin: 25px 20px 0px 20px;padding: 0px 0px 0px 15px;line-height: 24px;height: 26px;overflow: hidden;font-size: 12px;font-family: verdana;position: relative;}
		.tabrow li {cursor:pointer;border: 1px solid #AAA;background: #D1D1D1;background: -o-linear-gradient(top, #ECECEC 50%, #D1D1D1 100%);background: -ms-linear-gradient(top, #ECECEC 50%, #D1D1D1 100%);background: -moz-linear-gradient(top, #ECECEC 50%, #D1D1D1 100%);background: -webkit-linear-gradient(top, #ECECEC 50%, #D1D1D1 100%);background: linear-gradient(top, #ECECEC 50%, #D1D1D1 100%);display: inline-block;position: relative;z-index: 0;border-top-left-radius: 6px;border-top-right-radius: 6px;box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4), inset 0 1px 0 #FFF;text-shadow: 0 1px #FFF;margin: 0 -5px;padding: 0 20px;}
		.tabrow a {color: #555;text-decoration: none;}
		.tabrow li.selected {background: #FFF;color: #333;z-index: 2;border-bottom-color: #FFF;}
		.tabrow:before {position: absolute;content: " ";width: 100%;bottom: 0;left: 0;border-bottom: 1px solid #AAA;z-index: 1;}
		.tabrow li:before,.tabrow li:after {border: 1px solid #AAA;position: absolute;bottom: -1px;width: 5px;height: 5px;content: " ";}
		.tabrow li:before {left: -6px;border-bottom-right-radius: 6px;border-width: 0 1px 1px 0;box-shadow: 2px 2px 0 #D1D1D1;}
		.tabrow li:after {right: -6px;border-bottom-left-radius: 6px;border-width: 0 0 1px 1px;box-shadow: -2px 2px 0 #D1D1D1;}
		.tabrow li.selected:before {box-shadow: 2px 2px 0 #FFF;}
		.tabrow li.selected:after {box-shadow: -2px 2px 0 #FFF;}
		.tabs{width:940px;}
		.tabcontent {position:relative;margin: 0px 20px 25px 20px;padding: 0px 0px 0px 15px;width:883px;min-height:550px;display:block;}
		.tabcontent>div {margin-left:-15px;padding:15px;background-color:#ffffff;width:868px;border-left: 1px solid #aaaaaa;border-right: 1px solid #aaaaaa;border-bottom: 1px solid #aaaaaa;}
		.total, .news {font-weight:normal;font-size:12px;}
		.popup {color:#02779f; cursor:pointer;}
		/* ============================= 1. FANCYBOX ================================ */
		#fancybox-loading{position:fixed;top:50%;left:50%;width:40px;height:40px;margin-top:-20px;margin-left:-20px;cursor:pointer;overflow:hidden;z-index:1104;display:none;}
		#fancybox-loading div{position:absolute;top:0;left:0;width:40px;height:480px;background-image:url(../images/fancybox/images/fancybox.png);}
		#fancybox-overlay{position:absolute;top:0;left:0;width:100%;z-index:1100;display:none;}
		#fancybox-tmp{border:0;overflow:auto;display:none;margin:0;padding:0;}
		#fancybox-wrap{position:absolute;top:0;left:0;z-index:1101;outline:none;display:none;padding:20px;}
		#fancybox-outer{position:relative;width:100%;height:100%;background:#fff;}
		#fancybox-content{width:0;height:0;outline:none;position:relative;overflow:hidden;z-index:1102;border:0 solid #fff;padding:0;}
		#fancybox-hide-sel-frame{position:absolute;top:0;left:0;width:100%;height:100%;background:transparent;z-index:1101;}
		#fancybox-close{position:absolute;top:-15px;right:-15px;width:30px;height:30px;background:transparent url(../images/fancybox/images/fancybox.png) -40px 0;cursor:pointer;z-index:1103;display:none;}
		#fancybox-error{color:#444;font:normal 12px/20px Arial;margin:0;padding:14px;}
		#fancybox-img{width:100%;height:100%;border:none;outline:none;line-height:0;vertical-align:top;margin:0;padding:0;}
		#fancybox-frame{width:100%;height:100%;border:none;display:block;}
		#fancybox-left,#fancybox-right{position:absolute;bottom:0;height:100%;width:35%;cursor:pointer;outline:none;background:transparent url(../images/fancybox/images/blank.gif);z-index:1102;display:none;}
		#fancybox-left{left:0;}
		#fancybox-right{right:0;}
		#fancybox-left-ico,#fancybox-right-ico{position:absolute;top:50%;left:-9999px;width:30px;height:30px;margin-top:-15px;cursor:pointer;z-index:1102;display:block;}
		#fancybox-left-ico{background-image:url(../images/fancybox/images/fancybox.png);background-position:-40px -30px;}
		#fancybox-right-ico{background-image:url(../images/fancybox/images/fancybox.png);background-position:-40px -60px;}
		#fancybox-left:hover,#fancybox-right:hover{visibility:visible;}
		#fancybox-left:hover span{left:20px;}
		#fancybox-right:hover span{left:auto;right:20px;}
		.fancybox-bg{position:absolute;border:0;width:20px;height:20px;z-index:1001;margin:0;padding:0;}
		#fancybox-bg-n{top:-20px;left:0;width:100%;background-image:url(../images/fancybox/images/fancybox-x.png);}
		#fancybox-bg-ne{top:-20px;right:-20px;background-image:url(../images/fancybox/images/fancybox.png);background-position:-40px -162px;}
		#fancybox-bg-e{top:0;right:-20px;height:100%;background-image:url(../images/fancybox/images/fancybox-y.png);background-position:-20px 0;}
		#fancybox-bg-se{bottom:-20px;right:-20px;background-image:url(../images/fancybox/images/fancybox.png);background-position:-40px -182px;}
		#fancybox-bg-s{bottom:-20px;left:0;width:100%;background-image:url(../images/fancybox/images/fancybox-x.png);background-position:0 -20px;}
		#fancybox-bg-sw{bottom:-20px;left:-20px;background-image:url(../images/fancybox/images/fancybox.png);background-position:-40px -142px;}
		#fancybox-bg-w{top:0;left:-20px;height:100%;background-image:url(../images/fancybox/images/fancybox-y.png);}
		#fancybox-bg-nw{top:-20px;left:-20px;background-image:url(../images/fancybox/images/fancybox.png);background-position:-40px -122px;}
		#fancybox-title{font-family:Helvetica;font-size:12px;z-index:1102;}
		.fancybox-title-inside{padding-bottom:10px;text-align:center;color:#333;background:#fff;position:relative;}
		.fancybox-title-outside{padding-top:10px;color:#fff;}
		.fancybox-title-over{position:absolute;bottom:0;left:0;color:#FFF;text-align:left;}
		#fancybox-title-over{background-image:url(../images/fancybox/images/fancy_title_over.png);display:block;padding:10px;}
		.fancybox-title-float{position:absolute;left:0;bottom:-20px;height:32px;}
		#fancybox-title-float-wrap{border:none;border-collapse:collapse;width:auto;}
		#fancybox-title-float-wrap td{border:none;white-space:nowrap;}
		#fancybox-title-float-left{background:url(../images/fancybox/images/fancybox.png) -40px -90px no-repeat;padding:0 0 0 15px;}
		#fancybox-title-float-main{color:#FFF;line-height:29px;font-weight:700;background:url(../images/fancybox/images/fancybox-x.png) 0 -40px;padding:0 0 3px;}
		#fancybox-title-float-right{background:url(../images/fancybox/images/fancybox.png) -55px -90px no-repeat;padding:0 0 0 15px;}
		#fancybox-content { border-color: #ffffff!important;}
		#fancybox-outer { background-color: #fff!important; }
		.fancyboxhide {opacity:0;}
		/* Honeywell  */
		.htitle{font-size:1.1em; font-weight:bold;}.subitem{border:1px solid #ccc; padding:10px;}.delete-item, .delete-itemh{float:right;text-align:right;color:#ff0000;font-weight:bold;cursor:pointer;}
		.normal-format{list-style: decimal}.normal-format>li{margin-left:20px;margin-bottom:15px;font-size:16px;}
</style>
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="title" Runat="Server">
</asp:Content>
<asp:Content ID="Content3" ContentPlaceHolderID="contents" Runat="Server">
<div class="mtd">
	<div class="sub-menu" style="text-align:right;width:100%;">
		<asp:DropDownList ID="ddmenu" runat="server" CssClass="select-menu"></asp:DropDownList>
		<div class="top20"><input type="button" class="newtemplate" title="Add New Template" value="Add New Template" /></div>
	</div>
		<div class="tabs">
			<ul class="tabrow">
				<li class="selected" ref="1">Create Media Highlights</li>
				<li ref="2">Instructions</li>
			</ul>
		</div>
		<div class="tabcontent">
			<div class="tab1">
				<div class="sub-menu dbid" runat="server" id="newsid" ref="0"></div>
				<form name="highlights" class="nform">
					<div class="formitem">
						<div class="htitle">Email Lead In</div>
						<textarea class="leadin top10" id="leadin" runat="server">Please see recent Honeywell news and other company highlights from our online newsfeed, Honeywell Now, below. Full stories in company news (included below) are also in the attached Word document and available on BoardVantage for your convenience. Please note that newsfeed story links will send you directly to the source on Honeywell's website. For assistance, contact Marybeth Tassinari at 973-455-6878.</textarea> 
					</div>
					<hr class="top20" />
					<div class="news top20">
						<div class="htitle">Company News</div>
						<div class="formitem top10">
							<label for="storycount">News Count</label>
							<input type="text" name="storycount" class="storycount"  id="storycount" runat="server" />
						</div>
						<div class="newsitemlist" runat="server" id="news"></div>
					</div>
					<div class="top20"><input type="button" class="newnews" title="Add New News Item" value="Add New News Item" /></div>
					<hr class="top20" />
					<div class="highlights top20">
						<div class="htitle">Newsfeed Highlights</div>
						<div class="highlightitemlist" runat="server" id="highlights"></div>
					</div>
					<div class="top20"><input type="button" class="newhighlight" title="Add New Highlight Item" value="Add New Highlight Item" /></div>
					<hr class="top20" />
					<div class="top20"><input type="button" class="save" title="Save" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="preview" title="Preview" value="Preview" ref="" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="download" title="Download" value="Download" ref="" /></div>
				</form>
			</div>
			<div class="tab2">
				<div class="sub-menu">Email Template Instructions</div>
				<div>
					<a href="board_clips_process.pdf" title="Template Instructions">Download the Template Instructions</a>
				</div>
			</div>
		</div>
		<div class="clearing">&nbsp;<!-- IE Fix --></div>
	</div>
</div>
</asp:Content>
<asp:Content ID="Content4" ContentPlaceHolderID="scripts" Runat="Server">
<script src="../scripts/tiny_mce/tiny_mce.js"></script>
<script src="../scripts/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
	var entry = {
		news: '<div class="subitem top10 newsitem"><div class="delete-item">DELETE</div><div class="top10 itemtitle">~title~</div><div class="formitem top10"><label for="newstitle">News Title</label><input name="" class="newstitle" /></div><div class="formitem top10"><label for="newstitle">News Source</label><input name="" class="newssource" /></div><div class="formitem top10"><label for="newstitle">News Date</label><input name="" class="newsdate" /></div><div class="top10">Story Content</div><textarea class="leadin rtf top10" id="~newsid~"></textarea></div>',
		highlight: '<div class="subitem top10 highlightitem"><div class="delete-itemh">DELETE</div><div class="top10 itemtitle">~title~</div><div class="formitem top10"><label for="highlighttitle">Highlight Title</label><input name="" class="highlighttitle" /></div><div class="formitem top10"><label for="highlightlink">Highlight Link: Please put the full URL in this field including the "http://"</label><input name="" class="highlightlink" /></div></div>',
		newscount: 0,
		highlightcount: 0,
		newscontent: "",
		leadin: "",
		count: "",
		highlightcontent: "",
		init: function () {
			jQuery(".preview").bind("click", function() {
				window.open(jQuery(this).attr("ref"));
			});
			jQuery(".download").bind("click", function() {
				window.location.href = jQuery(this).attr("ref");
			});
			jQuery(".preview").hide();
			jQuery(".download").hide();
			jQuery(".newnews").bind("click", function (e) {
				e.preventDefault();
				entry.newscount++;
				jQuery(".newsitemlist").append(entry.news.replace("~title~", "News " + entry.newscount).replace("~newsid~", "news" + entry.newscount));
				entry.rtf("news" + entry.newscount);
				jQuery(".delete-item").bind("click", function() {
					jQuery(this).parent().remove();
					entry.newscount--;
				});
			});
			jQuery(".newhighlight").bind("click", function (e) {
				e.preventDefault();
				entry.highlightcount++;
				jQuery(".highlightitemlist").append(entry.highlight.replace("~title~", "Highlight " + entry.highlightcount));
				jQuery("input").focus(function () {
					jQuery(this).parent().find("label").css({ opacity: .1 });
				}).blur(function () {
					if (jQuery(this).val() == "") { jQuery(this).parent().find("label").css({ opacity: 1 }); } else { jQuery(this).parent().find("label").css({ opacity: 0 }); };
				}).bind("keypress", function () {
					jQuery(this).parent().find("label").css({ opacity: 0 });
				});
				jQuery("label").bind("click", function () { jQuery(this).parent().find("input").focus(); });
				jQuery(".delete-itemk").bind("click", function() {
					jQuery(this).parent().remove();
					entry.highlightcount--;
				});
			});
			jQuery(".save").bind("click", function () {
				entry.save();
			});
			jQuery("input").focus(function () {
				jQuery(this).parent().find("label").css({ opacity: .1 });
			}).blur(function () {
				if (jQuery(this).val() == "") { jQuery(this).parent().find("label").css({ opacity: 1 }); } else { jQuery(this).parent().find("label").css({ opacity: 0 }); };
			}).bind("keypress", function () {
				jQuery(this).parent().find("label").css({ opacity: 0 });
			}).each(function() {
				if(jQuery(this).val() != "" && jQuery(this).val() != undefined) {
					jQuery(this).parent().find("label").css({ opacity: 0 });
				}
			});;
			jQuery("label").bind("click", function () { jQuery(this).parent().find("input").focus(); });
			if(jQuery(".dbid").attr("ref") != "0") {
				jQuery(".rtf").each(function() {
					tinymce.init({
						theme : "advanced",
						mode: "exact",
						elements: jQuery(this).attr("id"),
						plugins: "paste",
						theme_advanced_resizing : true,
						theme_advanced_buttons1 : "bold,italic,underline,link,unlink,cut,paste,pastetext,pasteword,undo,redo,bullist,numlist",
						theme_advanced_buttons2: "hr,sub,sup",
					});
					entry.newscount++;
				});
				jQuery(".delete-item").bind("click", function() {
					jQuery(this).parent().remove();
					entry.newscount--;
				});
			}
			jQuery(".select-menu").change(function() {
				if(jQuery(this).val() != 0) {
					window.location.href = "/honeywell/account/media.aspx?id="+jQuery(this).val()
				}
			});
			jQuery(".newtemplate").bind("click",function() {
				window.location.href = "/honeywell/account/media.aspx"
			});
		},
		rtf: function (id) {
			tinymce.init({
				theme : "advanced",
				mode: "exact",
				elements: id,
				plugins: "paste",
				theme_advanced_resizing : true,
				theme_advanced_buttons1 : "bold,italic,underline,link,unlink,cut,paste,pastetext,pasteword,undo,redo,bullist,numlist",
				theme_advanced_buttons2: "hr,sub,sup",
			});
			jQuery("input").focus(function () {
				jQuery(this).parent().find("label").css({ opacity: .1 });
			}).blur(function () {
				if (jQuery(this).val() == "") { jQuery(this).parent().find("label").css({ opacity: 1 }); } else { jQuery(this).parent().find("label").css({ opacity: 0 }); };
			}).bind("keypress", function () {
				jQuery(this).parent().find("label").css({ opacity: 0 });
			});
			jQuery("label").bind("click", function () { jQuery(this).parent().find("input").focus(); });
		},
		save: function() {
			jQuery(".preview").hide();
			jQuery(".download").hide();
			var ctr = 1;
			entry.newscontent = "[";
			entry.highlightcontent = "[";
			entry.leadin = jQuery(".leadin").val();
			entry.count = jQuery(".storycount").val();
			jQuery(".newsitem").each(function () {
				if(ctr != 1) {entry.newscontent += ","}
				entry.newscontent += "{'title':'"+jQuery(".newstitle", this).val().replace(/’/g, "`").replace(/'/g, "`").replace(/-/g, "-").replace(/[\u2018\u2019]/g, "`").replace(/[\u201C\u201D]/g, "`")+"',";
				entry.newscontent += "'source':'"+jQuery(".newssource", this).val().replace(/’/g, "`").replace(/'/g, "`").replace(/-/g, "-").replace(/[\u2018\u2019]/g, "`").replace(/[\u201C\u201D]/g, "`")+"',";
				entry.newscontent += "'date':'"+jQuery(".newsdate", this).val().replace(/’/g, "`").replace(/'/g, "`").replace(/-/g, "-").replace(/[\u2018\u2019]/g, "`").replace(/[\u201C\u201D]/g, "`")+"',";
				entry.newscontent += "'content':'"+tinymce.get("news" + ctr).getContent().replace(/"/g, "'").replace(/\n/g, "").replace(/’/g, "`").replace(/'/g, "`").replace(/-/g, "-").replace(/[\u2018\u2019]/g, "`").replace(/[\u201C\u201D]/g, "`")+"'}";
				ctr++;
			});
			entry.newscontent  += "]";
			ctr = 1;
			jQuery(".highlightitem").each(function () {
				if(ctr != 1) {entry.highlightcontent += ","}
				entry.highlightcontent += "{'title':'"+jQuery(".highlighttitle", this).val()+"',";
				entry.highlightcontent += "'source':'"+jQuery(".highlightlink", this).val()+"'}";
				ctr++;
			});
			entry.highlightcontent  += "]";
			$.ajax({
				type: "POST",
				contentType: "application/json;charset=utf-8",
				url: "media.aspx/Submit",
				data: '{ "id": "'+jQuery(".dbid").attr("ref")+'",' +
						'"leadin": "' + entry.leadin + '",' +
						'"count": "' + entry.count + '",' +
						'"newsitems": "' + entry.newscontent + '",' +
						'"highlightitems": "' + entry.highlightcontent + '"' +
					' }',
				dataType: "json",
				success: function (data) {
					var item = data.d;
					jQuery(".dbid").attr("ref", item.NewID);
					jQuery(".preview").attr("ref", "export/"+item.ErrorMessage);
					jQuery(".preview").show();
					jQuery(".download").attr("ref", "export/default.aspx?file="+item.ErrorMessage);
					jQuery(".download").show();
				},
				complete: function () {
					//loading.hide();
				}
			});
		}
	}
	var tab = {
		previous: "0",
		selected: "1",
		count: 1,
		init: function () {
			var ctr = 0;
			$(".tabcontent div").each(function () {
				if (tab.count != 1) {
					$(".tab" + tab.count).hide();
				}
				tab.count++;
			});
			$(".tabrow li").click(function () {
				if (tab.selected != $(this).attr("ref")) {
					tab.previous = tab.selected;
					tab.selected = $(this).attr("ref");
					$("li").removeClass("selected");
					$(this).addClass("selected");
					$(".tab" + tab.previous).animate({ opacity: 0 }, { "queue": false, "duration": 300, 'easing': 'linear', complete: function () { $(".tab" + tab.previous).hide(); } });
					$(".tab" + tab.selected).show();
					$(".tab" + tab.selected).animate({ opacity: 1 }, { "queue": false, "duration": 400, 'easing': 'linear', complete: function () { } });
				}
			});
		}
	};
	jQuery(document).ready(function () {
		entry.init();
		tab.init();
	});
</script>
</asp:Content>