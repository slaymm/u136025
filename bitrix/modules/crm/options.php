<?php
##############################################
# Bitrix: SiteManager                        #
# Copyright (c) 2002-2010 Bitrix             #
# http://www.bitrixsoft.com                  #
# mailto:admin@bitrixsoft.com                #
##############################################

global $MESS;
include(GetLangFileName($GLOBALS['DOCUMENT_ROOT'].'/bitrix/modules/crm/lang/', '/options.php'));
IncludeModuleLangFile($_SERVER['DOCUMENT_ROOT'].BX_ROOT.'/modules/main/options.php');

$module_id = 'crm';
CModule::IncludeModule($module_id);

$MOD_RIGHT = $APPLICATION->GetGroupRight($module_id);
if($MOD_RIGHT>='R'):

	// set up form
	$sHost = $_SERVER['HTTP_HOST'];
	if (strpos($sHost, ':') !== false)
		$sHost = substr($sHost, 0, strpos($sHost, ':'));

	ob_start();
	$GLOBALS["APPLICATION"]->IncludeComponent('bitrix:intranet.user.selector',
		'',
		array(
			'INPUT_NAME' => 'sale_deal_assigned_by_id_tmp',
			'INPUT_VALUE' => COption::GetOptionString("crm", "sale_deal_assigned_by_id", ""),
			'MULTIPLE' => 'N'
		),
		null,
		array('HIDE_ICONS' => 'Y')
	);
	$sVal = ob_get_contents();
	ob_end_clean();

	$arOptionsBase = array(
		array("sale_deal_opened", GetMessage("CRM_SALE_DEAL_OPENED_2"), "Y", array("checkbox")),
		array("sale_deal_probability", GetMessage("CRM_SALE_DEAL_PROBABILITY_2"), "100", array("text")),
		array("sale_deal_assigned_by_id_tmp", GetMessage("CRM_SALE_DEAL_ASSIGNED_BY_ID_2"), $sVal, array("statichtml")),
		GetMessage("CRM_PROXY_TITLE"),
		array("proxy_scheme", GetMessage("CRM_PROXY_SCHEME"), "http", array("selectbox", array("http" => "HTTP", "https" => "HTTPS"))),
		array("proxy_host", GetMessage("CRM_PROXY_SERVER"), "", array("text")),
		array("proxy_port", GetMessage("CRM_PROXY_PORT"), "80", array("text")),
		array("proxy_username", GetMessage("CRM_PROXY_USERNAME"), "", array("text")),
		array("proxy_password", GetMessage("CRM_PROXY_PASSWORD"), "", array("password")),
	);
	$arOptionsPath = array(
		array('path_to_lead_list', GetMessage('CRM_OPTIONS_PATH_TO_LEAD_LIST'), '/crm/lead/list/', Array('text', '40')),
		array('path_to_lead_show', GetMessage('CRM_OPTIONS_PATH_TO_LEAD_SHOW'), '/crm/lead/show/#lead_id#/', Array('text', '40')),
		array('path_to_lead_edit', GetMessage('CRM_OPTIONS_PATH_TO_LEAD_EDIT'), '/crm/lead/edit/#lead_id#/', Array('text', '40')),
		array('path_to_lead_convert', GetMessage('CRM_OPTIONS_PATH_TO_LEAD_CONVERT'), '/crm/lead/convert/', Array('text', '40')),
		array('path_to_lead_import', GetMessage('CRM_OPTIONS_PATH_TO_LEAD_IMPORT'), '/crm/lead/import/', Array('text', '40')),
		array('path_to_deal_list', GetMessage('CRM_OPTIONS_PATH_TO_DEAL_LIST'), '/crm/deal/list/', Array('text', '40')),
		array('path_to_deal_show', GetMessage('CRM_OPTIONS_PATH_TO_DEAL_SHOW'), '/crm/deal/show/#deal_id#/', Array('text', '40')),
		array('path_to_deal_edit', GetMessage('CRM_OPTIONS_PATH_TO_DEAL_EDIT'), '/crm/deal/edit/#deal_id#/', Array('text', '40')),
		array('path_to_deal_import', GetMessage('CRM_OPTIONS_PATH_TO_DEAL_IMPORT'), '/crm/deal/import/', Array('text', '40')),
		array('path_to_deal_widget', GetMessage('CRM_OPTIONS_PATH_TO_DEAL_WIDGET'), '/crm/deal/widget/', Array('text', '40')),
		array('path_to_quote_list', GetMessage('CRM_OPTIONS_PATH_TO_QUOTE_LIST'), '/crm/quote/list/', Array('text', '40')),
		array('path_to_quote_show', GetMessage('CRM_OPTIONS_PATH_TO_QUOTE_SHOW'), '/crm/quote/show/#quote_id#/', Array('text', '40')),
		array('path_to_quote_edit', GetMessage('CRM_OPTIONS_PATH_TO_QUOTE_EDIT'), '/crm/quote/edit/#quote_id#/', Array('text', '40')),
		array('path_to_quote_import', GetMessage('CRM_OPTIONS_PATH_TO_QUOTE_IMPORT'), '/crm/quote/import/', Array('text', '40')),
		array('path_to_contact_list', GetMessage('CRM_OPTIONS_PATH_TO_CONTACT_LIST'), '/crm/contact/list/', Array('text', '40')),
		array('path_to_contact_show', GetMessage('CRM_OPTIONS_PATH_TO_CONTACT_SHOW'), '/crm/contact/show/#contact_id#/', Array('text', '40')),
		array('path_to_contact_edit', GetMessage('CRM_OPTIONS_PATH_TO_CONTACT_EDIT'), '/crm/contact/edit/#contact_id#/', Array('text', '40')),
		array('path_to_contact_import', GetMessage('CRM_OPTIONS_PATH_TO_CONTACT_IMPORT'), '/crm/contact/import/', Array('text', '40')),
		array('path_to_company_list', GetMessage('CRM_OPTIONS_PATH_TO_COMPANY_LIST'), '/crm/company/list/', Array('text', '40')),
		array('path_to_company_show', GetMessage('CRM_OPTIONS_PATH_TO_COMPANY_SHOW'), '/crm/company/show/#company_id#/', Array('text', '40')),
		array('path_to_company_edit', GetMessage('CRM_OPTIONS_PATH_TO_COMPANY_EDIT'), '/crm/company/edit/#company_id#/', Array('text', '40')),
		array('path_to_company_import', GetMessage('CRM_OPTIONS_PATH_TO_COMPANY_IMPORT'), '/crm/company/import/', Array('text', '40')),
		array('path_to_invoice_list', GetMessage('CRM_OPTIONS_PATH_TO_INVOICE_LIST'), '/crm/invoice/list/', Array('text', '40')),
		array('path_to_invoice_show', GetMessage('CRM_OPTIONS_PATH_TO_INVOICE_SHOW'), '/crm/invoice/show/#invoice_id#/', Array('text', '40')),
		array('path_to_invoice_edit', GetMessage('CRM_OPTIONS_PATH_TO_INVOICE_EDIT'), '/crm/invoice/edit/#invoice_id#/', Array('text', '40')),
		array('path_to_invoice_payment', GetMessage('CRM_OPTIONS_PATH_TO_INVOICE_PAYMENT'), '/crm/invoice/payment/#invoice_id#/', Array('text', '40')),
		array('path_to_user_profile', GetMessage('CRM_OPTIONS_PATH_TO_USER_PROFILE'), '/company/personal/user/#user_id#/', Array('text', '40')),
		array('path_to_user_bp', GetMessage('CRM_OPTIONS_PATH_TO_BP'), '/company/personal/bizproc/', Array('text', '40')),
		array('path_to_activity_list', GetMessage('CRM_OPTIONS_PATH_TO_ACTIVITY_LIST'), '/crm/activity/', Array('text', '40')),
		array('path_to_activity_show', GetMessage('CRM_OPTIONS_PATH_TO_ACTIVITY_SHOW'), '/crm/activity/?ID=#activity_id#&open_view=#activity_id#', Array('text', '40')),
		array('path_to_activity_edit', GetMessage('CRM_OPTIONS_PATH_TO_ACTIVITY_EDIT'), '/crm/activity/?ID=#activity_id#&open_edit=#activity_id#', Array('text', '40')),
		array('path_to_perm_list', GetMessage('CRM_OPTIONS_PATH_TO_PERM_LIST'), '/crm/configs/perms/', Array('text', '40')),
	);

	$arAllOptions = array_merge($arOptionsPath, $arOptionsBase);

if($MOD_RIGHT>='Y' || $USER->IsAdmin()):

	if ($REQUEST_METHOD=='GET' && strlen($RestoreDefaults)>0 && check_bitrix_sessid())
	{
		COption::RemoveOption($module_id);
	}

	if($REQUEST_METHOD=='POST' && strlen($Update)>0 && check_bitrix_sessid())
	{
		$arOptions = $arAllOptions;
		foreach($arOptions as $option)
		{
			if(!is_array($option))
				continue;

			$name = $option[0];
			$val = ${$name};
			if($option[3][0] == 'checkbox' && $val != 'Y')
				$val = 'N';
			if($option[3][0] == 'multiselectbox')
				$val = @implode(',', $val);
			if($name == 'sale_deal_assigned_by_id_tmp')
			{
				$name = 'sale_deal_assigned_by_id';
				if (is_array($val) && count($val) > 0)
					$val = $val[0];
			}

			COption::SetOptionString($module_id, $name, $val, $option[1]);
		}

		if(strlen($_REQUEST["back_url_settings"])>0)
			LocalRedirect($_REQUEST["back_url_settings"]);
		else
			LocalRedirect($APPLICATION->GetCurPage()."?mid=".urlencode($mid)."&lang=".urlencode(LANGUAGE_ID)."&back_url_settings=".urlencode($_REQUEST["back_url_settings"]));
	}

endif; //if($MOD_RIGHT>="W"):

$aTabs = array();
$aTabs[] = array('DIV' => 'set', 'TAB' => GetMessage('MAIN_TAB_SET'), 'ICON' => 'crm_settings', 'TITLE' => GetMessage('MAIN_TAB_TITLE_SET'));
$aTabs[] = array('DIV' => 'path', 'TAB' => GetMessage('CRM_TAB_PATH'), 'ICON' => 'crm_path', 'TITLE' => GetMessage('CRM_TAB_TITLE_PATH'));
//$aTabs[] = array('DIV' => 'rights', 'TAB' => GetMessage('MAIN_TAB_RIGHTS'), 'ICON' => 'crm_settings', 'TITLE' => GetMessage('MAIN_TAB_TITLE_RIGHTS'));

$tabControl = new CAdminTabControl('tabControl', $aTabs);
?>
<?$tabControl->Begin();?>
<form method="POST" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&lang=<?=LANGUAGE_ID?>">
<?$tabControl->BeginNextTab();?>
<?__AdmSettingsDrawList('crm', $arOptionsBase);?>
<?//$tabControl->BeginNextTab();?>
<?//__AdmSettingsDrawList('crm', $arOptionsBase);?>
<?$tabControl->BeginNextTab();?>
<?__AdmSettingsDrawList('crm', $arOptionsPath);?>
<?//$tabControl->BeginNextTab();?>
<?//require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/admin/group_rights.php');?>
<?$tabControl->Buttons();?>
<script language="JavaScript">
function RestoreDefaults()
{
	if(confirm('<?echo AddSlashes(GetMessage('MAIN_HINT_RESTORE_DEFAULTS_WARNING'))?>'))
		window.location = "<?echo $APPLICATION->GetCurPage()?>?RestoreDefaults=Y&lang=<?echo LANG?>&mid=<?echo urlencode($mid)."&".bitrix_sessid_get();?>";
}
</script>
<input type="submit" name="Update" <?if ($MOD_RIGHT<'W') echo "disabled" ?> value="<?echo GetMessage('MAIN_SAVE')?>">
<input type="reset" name="reset" value="<?echo GetMessage('MAIN_RESET')?>">
<input type="hidden" name="Update" value="Y">
<?=bitrix_sessid_post();?>
<input type="button" <?if ($MOD_RIGHT<'W') echo "disabled" ?> title="<?echo GetMessage('MAIN_HINT_RESTORE_DEFAULTS')?>" OnClick="RestoreDefaults();" value="<?echo GetMessage('MAIN_RESTORE_DEFAULTS')?>">
<?$tabControl->End();?>
</form>
<?endif;
?>