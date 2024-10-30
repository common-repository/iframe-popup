function _iframepopup_submit()
{
	if(document.iframepopup_form.url.value == "")
	{
		alert(iframepopup_adminscripts.iframepopup_url)
		document.iframepopup_form.url.focus();
		return false;
	}
	else if(document.iframepopup_form.title.value == "")
	{
		alert(iframepopup_adminscripts.iframepopup_title)
		document.iframepopup_form.title.focus();
		return false;
	}
}

function _iframepopup_submit_setting()
{
	if(document.iframepopup_form_setting.iframepopup_session.value == "")
	{
		alert(iframepopup_adminscripts.iframepopup_session)
		document.iframepopup_form_setting.iframepopup_session.focus();
		return false;
	}
}

function _iframepopup_delete(id)
{
	if(confirm(iframepopup_adminscripts.iframepopup_delete))
	{
		document.frm_iframepopup_display.action="options-general.php?page=iframe-popup&ac=del&did="+id;
		document.frm_iframepopup_display.submit();
	}
}	

function _iframepopup_redirect()
{
	window.location = "options-general.php?page=iframe-popup";
}

function _iframepopup_help()
{
	window.open("http://www.gopiplus.com/work/2014/04/13/iframe-popup-wordpress-plugin/");
}