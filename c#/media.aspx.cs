using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.Script.Services;
using System.Globalization;
using System.Data;
using System.Data.Common;
using System.Configuration;
using Microsoft.Practices.EnterpriseLibrary.Data;
using System.Text;
using System.Drawing;
using System.Drawing.Imaging;
using ImageResizer;
using Newtonsoft;
using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using System.Drawing.Drawing2D;
using System.Net;
using System.IO;

public partial class account_media : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        if (!String.IsNullOrEmpty(Request.QueryString["id"]))
        {
            newsid.Attributes["ref"] = Request.QueryString["id"];
            string newsitem = "<div class='subitem top10 newsitem'><div class='delete-item'>DELETE</div><div class='top10 itemtitle'>~name~</div><div class='formitem top10'><label for='newstitle'>News Title</label><input name='' class='newstitle' value='~title~' /></div><div class='formitem top10'><label for='newstitle'>News Source</label><input name='' class='newssource'  value='~source~' /></div><div class='formitem top10'><label for='newstitle'>News Date</label><input name='' class='newsdate'  value='~date~' /></div><div class='top10'>Story Content</div><textarea class='leadin rtf top10' id='~newsid~'>~content~</textarea></div>";
            string highlightitem = "<div class='subitem top10 highlightitem'><div class='delete-item'>DELETE</div><div class='top10 itemtitle'>~name~</div><div class='formitem top10'><label for='highlighttitle'>Highlight Title</label><input name='' class='highlighttitle' value='~title~' /></div><div class='formitem top10'><label for='highlightlink'>Highlight Link: Please put the full URL in this field including the 'http://'</label><input name='' class='highlightlink' value='~source~' /></div></div>";
            Entry item = new Entry();
            DataTable dtFB = null;
            GenericDatabase db = new GenericDatabase(ConfigurationManager.ConnectionStrings["ConnectionString"].ConnectionString, DbProviderFactories.GetFactory("MySql.Data.MySqlClient"));
            DbCommand cmd = db.GetSqlStringCommand("Select * from media where id ='" + Request.QueryString["id"] + "'");
            dtFB = db.ExecuteDataSet(cmd).Tables[0];
            cmd.Dispose();
            foreach (DataRow row in dtFB.Rows)
            {
                item.LeadIn = row["leadin"].ToString();
                item.Count = row["newscount"].ToString();
                item.NewItems = row["newsitem"].ToString();
                item.HighlightItems = row["highlightitem"].ToString();
                newsid.InnerText = row["name"].ToString();
            }
            leadin.Value = item.LeadIn;
            List<News> newitems = new System.Web.Script.Serialization.JavaScriptSerializer().Deserialize<List<News>>(item.NewItems);
            string tmp = "";
            Int32 ctr = 1;
            foreach (News x in newitems)
            {
                tmp += newsitem.Replace("~name~", "News " + ctr.ToString()).Replace("~title~", x.Title).Replace("~source~", x.Source).Replace("~date~", x.Date).Replace("~newsid~", "news" + ctr.ToString()).Replace("~content~", x.Content);
                ctr++;
            }
            news.InnerHtml = tmp;
            tmp = "";
            List<Highlight> highitems = new System.Web.Script.Serialization.JavaScriptSerializer().Deserialize<List<Highlight>>(item.HighlightItems);
            ctr = 1;
            foreach (Highlight x in highitems)
            {
                tmp += highlightitem.Replace("~name~", "Highlight  " + ctr.ToString()).Replace("~title~", x.Title).Replace("~source~", x.Source);
                ctr++;
            }
            highlights.InnerHtml = tmp;
            //leadin.Value = item.LeadIn;
            storycount.Value = item.Count;
        }
        DataTable dtFBa = null;
        GenericDatabase dba = new GenericDatabase(ConfigurationManager.ConnectionStrings["ConnectionString"].ConnectionString, DbProviderFactories.GetFactory("MySql.Data.MySqlClient"));
        DbCommand cmda = dba.GetSqlStringCommand("Select id, name from media order by id desc");
        dtFBa = dba.ExecuteDataSet(cmda).Tables[0];
        cmda.Dispose();
        ListItem mn = new ListItem();
        mn.Text = "Select Saved Email Template";
        mn.Value = "0";
        ddmenu.Items.Add(mn);
        foreach (DataRow row in dtFBa.Rows)
        {
            mn = new ListItem();
            mn.Text = row["name"].ToString();
            mn.Value= row["id"].ToString();
            ddmenu.Items.Add(mn);
        }
    }
    [System.Web.Services.WebMethod()]
    [ScriptMethod(ResponseFormat = ResponseFormat.Json)]
    public static Status Submit(int id, string leadin, string count, string newsitems, string highlightitems)
    {
        Status stat = new Status();
        GenericDatabase db = new GenericDatabase(ConfigurationManager.ConnectionStrings["ConnectionString"].ConnectionString, DbProviderFactories.GetFactory("MySql.Data.MySqlClient"));
        DbCommand cmd = db.GetStoredProcCommand("ins_media");
        DateTime dte = DateTime.Now;
        string name = "";
        name = "BOD_News_" + GetWeekNumber(dte).ToString() + "_"+id.ToString() +"_"+ dte.Year.ToString();
        db.AddOutParameter(cmd, "ReturnCode", DbType.Int32, 8);
        db.AddOutParameter(cmd, "ErrorMessage", DbType.String, 500);
        db.AddOutParameter(cmd, "NewID", DbType.Int32, 8);
        db.AddInParameter(cmd, "InID", DbType.Int32, id);
        db.AddInParameter(cmd, "InName", DbType.String, name);
        db.AddInParameter(cmd, "InLeadin", DbType.String, leadin);
        db.AddInParameter(cmd, "InCount", DbType.String, count);
        db.AddInParameter(cmd, "InNewsItems", DbType.String, newsitems);
        db.AddInParameter(cmd, "InHighlightItems", DbType.String, highlightitems);
        db.ExecuteNonQuery(cmd);
        stat.ReturnCode = db.GetParameterValue(cmd, "ReturnCode") != null ? (Int32)db.GetParameterValue(cmd, "ReturnCode") : 0;
        stat.ErrorMessage = name+".html";
        stat.NewID = db.GetParameterValue(cmd, "NewID") != null ? db.GetParameterValue(cmd, "NewID").ToString() : "0";
        Entry item = new Entry();
        item.Name = name;
        item.LeadIn = leadin;
        item.NewItems = newsitems;
        item.HighlightItems = highlightitems;
        item.Count = count;
        CreateHTML(item);
        return stat;
    }
    public static int GetWeekNumber(DateTime dtPassed)
    {
        CultureInfo ciCurr = CultureInfo.CurrentCulture;
        int weekNum = ciCurr.Calendar.GetWeekOfYear(dtPassed, CalendarWeekRule.FirstFourDayWeek, DayOfWeek.Monday);
        return weekNum;
    }
    public static bool CreateHTML(Entry item)
    {
        var ok = true;
        string newslink = "<p style='padding:0;margin:0 0 15px;'><a href='#~newsid~' title='~title~'>~title~</a></p>";
        string highlightlink = "<p style='padding:0;margin:0 0 15px;'><a href='~hurl~' target='_blank' title='~htitle~'>~htitle~</a></p>";
        string newstemplate = "<p style='font-weight:bold;padding:0;margin:0 0 15px;'><a id='~newsid~' name='~newsid~'></a>~title~<br />~source~<br />~date~</p>~newscontent~	<p><a href='#top' title='back to top'>[back to top]</a></p>";
        string newsparagraph = "<p style='padding:0;margin:0 0 15px;'>";

        StreamReader reader = new StreamReader(HttpContext.Current.Server.MapPath("template/") + "template.html");
        string template = reader.ReadToEnd();
        reader.Close();
        reader.Dispose();
        template = template.Replace("~leadin~", item.LeadIn).Replace("~storycount~", item.Count);

        List<News> newitems = new System.Web.Script.Serialization.JavaScriptSerializer().Deserialize<List<News>>(item.NewItems);
        string tmp = "";
        Int32 ctr = 1;
        foreach (News x in newitems)
        {
            string str = newslink;
            str = str.Replace("~newsid~", "news"+ctr.ToString()).Replace("~title~", x.Source + " - " + x.Date + " - " +x.Title);
            tmp += str;
            ctr++;
        }
        template = template.Replace("~newsitems~", tmp);
        tmp = "";
        List<Highlight> highitems = new System.Web.Script.Serialization.JavaScriptSerializer().Deserialize<List<Highlight>>(item.HighlightItems);
        ctr = 1;
        foreach (Highlight x in highitems)
        {
            string str = highlightlink;
            str = str.Replace("~hurl~", x.Source).Replace("~htitle~", x.Title);
            tmp += str;
            ctr++;
        }
        template = template.Replace("~highlightitems~", tmp);
        tmp = "";
        ctr = 1;
        foreach (News x in newitems)
        {
            string str = newstemplate;
            str = str.Replace("~newsid~", "news" + ctr.ToString()).Replace("~title~", x.Title).Replace("~source~", x.Source).Replace("~date~", x.Date).Replace("~newscontent~", x.Content.Replace("<p>", newsparagraph));
            tmp += str;
            ctr++;
        }
        template = template.Replace("~newsitemcontent~", tmp);
        StreamWriter writer = new StreamWriter(HttpContext.Current.Server.MapPath("export/") +item.Name+".html", false);
        writer.Write(template);
        writer.Close();
        writer.Dispose();
        return ok;
    }
}
/// <summary>
/// Entity return Status of flow.
/// </summary>
public class Status
{
    public Int32 ReturnCode { get; set; }
    public string ErrorMessage { get; set; }
    public string NewID { get; set; }

    public Status()
    {
        ReturnCode = 0;
        ErrorMessage = "";
        NewID = "";
    }

}
public class Entry
{
    public int ID { get; set; }
    public string Name { get; set; }
    public string LeadIn { get; set; }
    public string Count { get; set; }
    public string NewItems { get; set; }
    public string HighlightItems { get; set; }

    public Entry()
    {
        ID = 0;
        Name = "";
        LeadIn = "";
        Count = "";
        NewItems = "";
        HighlightItems = "";
    }

}
public class News
{
    public string Title { get; set; }
    public string Source { get; set; }
    public string Date { get; set; }
    public string Content { get; set; }

    public News()
    {
        Title = "";
        Source = "";
        Date = "";
        Content = "";
    }

}
public class Highlight
{
    public string Title { get; set; }
    public string Source { get; set; }

    public Highlight()
    {
        Title = "";
        Source = "";
    }

}
