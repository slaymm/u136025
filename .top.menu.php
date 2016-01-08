<?
$aMenuLinks = Array(
	Array(
		"Выданные книги", 
		"/company/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Читатели", 
		"/company/read/lend/index.php", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Зарегистрировать выдачу", 
		"/docs/", 
		Array(), 
		Array(), 
		"CBXFeatures::IsFeatureEnabled('CommonDocuments')" 
	),
	Array(
		"Список книг", 
		"/services/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Список книг в наличии", 
		"/workgroups/", 
		Array(), 
		Array(), 
		"CBXFeatures::IsFeatureEnabled('Workgroups')" 
	),
	Array(
		"Контакты", 
		"/contacts/", 
		Array(), 
		Array(), 
		"CBXFeatures::IsFeatureEnabled('crm') && CModule::IncludeModule('crm') && CCrmPerms::IsAccessEnabled()" 
	)
);
?>