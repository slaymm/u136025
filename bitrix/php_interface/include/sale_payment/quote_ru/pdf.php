<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?
$arPaySysAction["ENCODING"] = "";
$ORDER_ID = IntVal($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["ID"]);
if (!is_array($arOrder))
	$arOrder = CSaleOrder::GetByID($ORDER_ID);

if (!CSalePdf::isPdfAvailable())
	die();

if(!function_exists('__CrmPaySysQuoteDrawFieldCell'))
{
	function __CrmPaySysQuoteDrawFieldCell($fields, $fieldName, $caption, $width, $height, $pdf)
	{
		if($fields[$fieldName])
		{
			list($string, $text) = $pdf->splitString(CSalePdf::prepareToPdf($caption.$fields[$fieldName]), $width - 10);
			$pdf->Cell($width, $height, $string);
		}
		else
		{
			$pdf->Cell($width, $height, '');
		}
	}
}

if ($_REQUEST['BLANK'] == 'Y')
	$blank = true;

$pdf = new CSalePdf('P', 'pt', 'A4');
if (CSalePaySystemAction::GetParamValue('BACKGROUND', false))
{
	$pdf->SetBackground(
		CSalePaySystemAction::GetParamValue('BACKGROUND', false),
		CSalePaySystemAction::GetParamValue('BACKGROUND_STYLE', false)
	);
}

$pageWidth  = $pdf->GetPageWidth();
$pageHeight = $pdf->GetPageHeight();

$pdf->AddFont('Font', '', 'pt_sans-regular.ttf', true);
$pdf->AddFont('Font', 'B', 'pt_sans-bold.ttf', true);

$fontFamily = 'Font';
$fontSize   = 10.5;

$margin = array(
	'top' => intval(CSalePaySystemAction::GetParamValue('MARGIN_TOP', false) ?: 15) * 72/25.4,
	'right' => intval(CSalePaySystemAction::GetParamValue('MARGIN_RIGHT', false) ?: 15) * 72/25.4,
	'bottom' => intval(CSalePaySystemAction::GetParamValue('MARGIN_BOTTOM', false) ?: 15) * 72/25.4,
	'left' => intval(CSalePaySystemAction::GetParamValue('MARGIN_LEFT', false) ?: 20) * 72/25.4
);

$width = $pageWidth - $margin['left'] - $margin['right'];

$pdf->SetDisplayMode(100, 'continuous');
$pdf->SetMargins($margin['left'], $margin['top'], $margin['right']);
$pdf->SetAutoPageBreak(true, $margin['bottom']);

$pdf->AddPage();


$y0 = $pdf->GetY();
$logoHeight = 0;
$logoWidth = 0;

if (CSalePaySystemAction::GetParamValue('PATH_TO_LOGO', false))
{
	list($imageHeight, $imageWidth) = $pdf->GetImageSize(CSalePaySystemAction::GetParamValue('PATH_TO_LOGO', false));

	$imgDpi = intval(CSalePaySystemAction::GetParamValue('LOGO_DPI', false)) ?: 96;
	$imgZoom = 96 / $imgDpi;

	$logoHeight = $imageHeight * $imgZoom + 5;
	$logoWidth  = $imageWidth * $imgZoom + 5;

	$pdf->Image(CSalePaySystemAction::GetParamValue('PATH_TO_LOGO', false), $pdf->GetX(), $pdf->GetY(), -$imgDpi, -$imgDpi);
}

$pdf->SetFont($fontFamily, 'B', $fontSize);

$sellerName =  CSalePaySystemAction::GetParamValue("SELLER_NAME", false);
if($sellerName)
{
	list($string, $text) = $pdf->splitString(CSalePdf::prepareToPdf($sellerName), $width - 10);
	$pdf->Cell($width, 15, $string, 0, 0, 'R');
	$pdf->Ln();
}

$sellerAddress = CSalePaySystemAction::GetParamValue("SELLER_ADDRESS", false);
if($sellerAddress)
{
	list($string, $text) = $pdf->splitString(CSalePdf::prepareToPdf($sellerAddress), $width - 10);
	$pdf->Cell($width, 15, $string, 0, 0, 'R');
	$pdf->Ln();
}

$sellerPhone = CSalePaySystemAction::GetParamValue("SELLER_PHONE", false);
if($sellerPhone)
{
	$sellerPhone = sprintf("Тел.: %s", $sellerPhone);
	$pdf->Cell($width, 15, $pdf->prepareToPdf($sellerPhone), 0, 0, 'R');
	$pdf->Ln();
}

$sellerEmail = CSalePaySystemAction::GetParamValue("SELLER_EMAIL", false);
if($sellerEmail)
{
	$sellerEmail = sprintf("E-mail: %s", $sellerEmail);
	$pdf->Cell($width, 15, $pdf->prepareToPdf($sellerEmail), 0, 0, 'R');
	$pdf->Ln();
}

$pdf->SetY(max($y0 + $logoHeight, $pdf->GetY()));
$pdf->SetFont($fontFamily, '', $fontSize);

$pdf->Ln();
$pdf->Ln();

$pdf->SetFont($fontFamily, 'B', $fontSize*1.5);
$billNo_tmp = CSalePdf::prepareToPdf(sprintf(
	"КОММЕРЧЕСКОЕ ПРЕДЛОЖЕНИЕ № %s от %s",
	$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["ACCOUNT_NUMBER"],
	CSalePaySystemAction::GetParamValue("DATE_INSERT", false)
));
$billNo_width = $pdf->GetStringWidth($billNo_tmp);
$pdf->Cell(0, 20, $billNo_tmp, 0, 0, 'C');
$pdf->Ln();

$pdf->SetFont($fontFamily, '', $fontSize);
if (CSalePaySystemAction::GetParamValue("ORDER_SUBJECT", false))
{
	$pdf->Cell($width/2-$billNo_width/2-2, 15, '');
	$pdf->MultiCell(0, 15, CSalePdf::prepareToPdf(CSalePaySystemAction::GetParamValue("ORDER_SUBJECT", false)), 0, 'L');
}

if (CSalePaySystemAction::GetParamValue("DATE_PAY_BEFORE", false))
{
	$pdf->Cell($width/2-$billNo_width/2-2, 15, '');
	$pdf->MultiCell(0, 15, CSalePdf::prepareToPdf(sprintf(
		"Срок действия %s",
		ConvertDateTime(CSalePaySystemAction::GetParamValue("DATE_PAY_BEFORE", false), FORMAT_DATE)
			?: CSalePaySystemAction::GetParamValue("DATE_PAY_BEFORE", false)
	)), 0, 'L');
}

$pdf->Ln();

$userFields = array();
for($i = 1; $i <= 5; $i++)
{
	$fildValue = CSalePaySystemAction::GetParamValue("USER_FIELD_{$i}", false);
	if($fildValue)
	{
		$userFields[] = $fildValue;
	}
}

if (CSalePaySystemAction::GetParamValue("COMMENT1", false)
	|| CSalePaySystemAction::GetParamValue("COMMENT2", false)
	|| !empty($userFields))
{
	$pdf->Write(15, CSalePdf::prepareToPdf('Условия и комментарии'));
	$pdf->Ln();

	$pdf->SetFont($fontFamily, '', $fontSize);

	if (CSalePaySystemAction::GetParamValue("COMMENT1", false))
	{
		$pdf->Write(15, HTMLToTxt(preg_replace(
			array('#</div>\s*<div[^>]*>#i', '#</?div>#i'), array('<br>', '<br>'),
			CSalePdf::prepareToPdf(CSalePaySystemAction::GetParamValue("COMMENT1", false))
		), '', array(), 0));
		$pdf->Ln();
		$pdf->Ln();
	}

	if (CSalePaySystemAction::GetParamValue("COMMENT2", false))
	{
		$pdf->Write(15, HTMLToTxt(preg_replace(
			array('#</div>\s*<div[^>]*>#i', '#</?div>#i'), array('<br>', '<br>'),
			CSalePdf::prepareToPdf(CSalePaySystemAction::GetParamValue("COMMENT2", false))
		), '', array(), 0));
		$pdf->Ln();
		$pdf->Ln();
	}

	foreach($userFields as &$userField)
	{
		$pdf->Write(15, HTMLToTxt(preg_replace(
			array('#</div>\s*<div[^>]*>#i', '#</?div>#i'), array('<br>', '<br>'),
			CSalePdf::prepareToPdf($userField)
		), '', array(), 0));
		$pdf->Ln();
		$pdf->Ln();
	}
	unset($userField);
}

$pdf->Ln();
$pdf->Ln();

// Список товаров
$arBasketItems = CSalePaySystemAction::GetParamValue("BASKET_ITEMS", false);
if(!is_array($arBasketItems))
	$arBasketItems = array();

$vat = 0;
if (!empty($arBasketItems))
{
	$arBasketItems = getMeasures($arBasketItems);

	$n = 0;
	$sum = 0.00;

	$arCurFormat = CCurrencyLang::GetCurrencyFormat($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"]);
	$currency = trim(str_replace('#', '', $arCurFormat['FORMAT_STRING']));

	$arColsCaption = array(
		1 => CSalePdf::prepareToPdf('№'),
		CSalePdf::prepareToPdf('Наименование товара'),
		CSalePdf::prepareToPdf('Кол-во'),
		CSalePdf::prepareToPdf('Ед.'),
		CSalePdf::prepareToPdf('Цена, '.$currency),
		CSalePdf::prepareToPdf('Скидка'),
		CSalePdf::prepareToPdf('Ставка НДС'),
		CSalePdf::prepareToPdf('Сумма, '.$currency)
	);
	$arCells = array();
	$arProps = array();
	$arRowsWidth = array(1 => 0, 0, 0, 0, 0, 0, 0, 0);

	for ($i = 1; $i <= 8; $i++)
		$arRowsWidth[$i] = max($arRowsWidth[$i], $pdf->GetStringWidth($arColsCaption[$i]));

	foreach($arBasketItems as &$arBasket)
	{
		$productName = $arBasket["NAME"];
		if ($productName == "OrderDelivery")
			$productName = htmlspecialcharsbx("Доставка");
		else if ($productName == "OrderDiscount")
			$productName = htmlspecialcharsbx("Скидка");

		// discount
		$discountValue = '0%';
		$discountSum = 0.0;
		$discountIsSet = false;
		if (is_array($arBasket['CRM_PR_FIELDS']))
		{
			if (isset($arBasket['CRM_PR_FIELDS']['DISCOUNT_TYPE_ID'])
				&& isset($arBasket['CRM_PR_FIELDS']['DISCOUNT_RATE'])
				&& isset($arBasket['CRM_PR_FIELDS']['DISCOUNT_SUM']))
			{
				if ($arBasket['CRM_PR_FIELDS']['DISCOUNT_TYPE_ID'] === \Bitrix\Crm\Discount::PERCENTAGE)
				{
					$discountValue = round(doubleval($arBasket['CRM_PR_FIELDS']['DISCOUNT_RATE']), 2).'%';
					$discountSum = round(doubleval($arBasket['CRM_PR_FIELDS']['DISCOUNT_SUM']), 2);
					$discountIsSet = true;
				}
				else if ($arBasket['CRM_PR_FIELDS']['DISCOUNT_TYPE_ID'] === \Bitrix\Crm\Discount::MONETARY)
				{
					$discountSum = round(doubleval($arBasket['CRM_PR_FIELDS']['DISCOUNT_SUM']), 2);
					$discountValue = SaleFormatCurrency($discountSum, $arBasket["CURRENCY"], false);
					$discountIsSet = true;
				}
			}
		}
		if ($discountIsSet && $discountSum > 0)
			$bShowDiscount = true;
		unset($discountIsSet);

		if ($bShowDiscount
			&& isset($arBasket['CRM_PR_FIELDS']['TAX_INCLUDED'])
			&& isset($arBasket['CRM_PR_FIELDS']['PRICE_NETTO'])
			&& isset($arBasket['CRM_PR_FIELDS']['PRICE_BRUTTO']))
		{
			if ($arBasket['CRM_PR_FIELDS']['TAX_INCLUDED'] === 'Y')
				$unitPrice = $arBasket['CRM_PR_FIELDS']["PRICE_BRUTTO"];
			else
				$unitPrice = $arBasket['CRM_PR_FIELDS']["PRICE_NETTO"];
		}
		else
		{
			$unitPrice = $arBasket["PRICE"];
		}
		$arCells[++$n] = array(
			1 => CSalePdf::prepareToPdf($n),
			CSalePdf::prepareToPdf($productName),
			CSalePdf::prepareToPdf(roundEx($arBasket["QUANTITY"], SALE_VALUE_PRECISION)),
			CSalePdf::prepareToPdf($arBasket["MEASURE_NAME"] ? $arBasket["MEASURE_NAME"] : 'шт.'),
			CSalePdf::prepareToPdf(SaleFormatCurrency($unitPrice, $arBasket["CURRENCY"]), true),
			CSalePdf::prepareToPdf($discountValue),
			CSalePdf::prepareToPdf(roundEx($arBasket["VAT_RATE"]*100, SALE_VALUE_PRECISION)."%"),
			CSalePdf::prepareToPdf(SaleFormatCurrency(
				$arBasket["PRICE"] * $arBasket["QUANTITY"],
				$arBasket["CURRENCY"],
				true
			))
		);

		if(isset($arBasket["PROPS"]) && is_array($arBasket["PROPS"]))
		{
			$arProps[$n] = array();
			foreach ($arBasket["PROPS"] as $vv)
				$arProps[$n][] = htmlspecialcharsbx(sprintf("%s: %s", $vv["NAME"], $vv["VALUE"]));
		}

		for ($i = 1; $i <= 8; $i++)
			$arRowsWidth[$i] = max($arRowsWidth[$i], $pdf->GetStringWidth($arCells[$n][$i]));

		$sum += doubleval($arBasket["PRICE"] * $arBasket["QUANTITY"]);
		$vat = max($vat, $arBasket["VAT_RATE"]);
	}
	unset($arBasket);

	if (DoubleVal($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["PRICE_DELIVERY"]) > 0)
	{
		$arDelivery_tmp = CSaleDelivery::GetByID($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["DELIVERY_ID"]);

		$sDeliveryItem = "Доставка";
		if (strlen($arDelivery_tmp["NAME"]) > 0)
			$sDeliveryItem .= sprintf(" (%s)", $arDelivery_tmp["NAME"]);
		$arCells[++$n] = array(
			1 => CSalePdf::prepareToPdf($n),
			CSalePdf::prepareToPdf($sDeliveryItem),
			CSalePdf::prepareToPdf(1),
			CSalePdf::prepareToPdf(''),
			CSalePdf::prepareToPdf(SaleFormatCurrency(
				$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["PRICE_DELIVERY"],
				$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"],
				true
			)),
			CSalePdf::prepareToPdf(''),
			CSalePdf::prepareToPdf(roundEx($vat*100, SALE_VALUE_PRECISION)."%"),
			CSalePdf::prepareToPdf(SaleFormatCurrency(
				$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["PRICE_DELIVERY"],
				$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"],
				true
			))
		);

		for ($i = 1; $i <= 8; $i++)
			$arRowsWidth[$i] = max($arRowsWidth[$i], $pdf->GetStringWidth($arCells[$n][$i]));

		$sum += doubleval($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["PRICE_DELIVERY"]);
	}

	$items = $n;

	if ($sum < $GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["PRICE"])
	{
		$arCells[++$n] = array(
			1 => null,
			null,
			null,
			null,
			null,
			null,
			CSalePdf::prepareToPdf("Подытог:"),
			CSalePdf::prepareToPdf(SaleFormatCurrency($sum, $GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"]), true)
		);

		$arRowsWidth[8] = max($arRowsWidth[8], $pdf->GetStringWidth($arCells[$n][8]));
	}

	$arTaxList = CSalePaySystemAction::GetParamValue("TAX_LIST", false);
	if(!is_array($arTaxList))
	{
		$dbTaxList = CSaleOrderTax::GetList(
			array("APPLY_ORDER" => "ASC"),
			array("ORDER_ID" => $ORDER_ID)
		);

		$arTaxList = array();
		while ($arTaxInfo = $dbTaxList->Fetch())
		{
			$arTaxList[] = $arTaxInfo;
		}
	}

	if(!empty($arTaxList))
	{
		foreach($arTaxList as &$arTaxInfo)
		{
			$arCells[++$n] = array(
				1 => null,
				null,
				null,
				null,
				null,
				null,
				CSalePdf::prepareToPdf(sprintf(
					"%s%s%s:",
					($arTaxInfo["IS_IN_PRICE"] == "Y") ? "В том числе " : "",
					$arTaxInfo["TAX_NAME"],
					($vat <= 0 && $arTaxInfo["IS_PERCENT"] == "Y")
						? sprintf(' (%s%%)', roundEx($arTaxInfo["VALUE"],SALE_VALUE_PRECISION))
						: ""
				)),
				CSalePdf::prepareToPdf(SaleFormatCurrency(
					$arTaxInfo["VALUE_MONEY"],
					$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"],
					true
				))
			);

			$arRowsWidth[8] = max($arRowsWidth[8], $pdf->GetStringWidth($arCells[$n][8]));
		}
		unset($arTaxInfo);
	}
	else
	{
		$arCells[++$n] = array(
			1 => null,
			null,
			null,
			null,
			null,
			null,
			null,
			CSalePdf::prepareToPdf("НДС:"),
			CSalePdf::prepareToPdf("Без НДС")
		);

		$arRowsWidth[8] = max($arRowsWidth[8], $pdf->GetStringWidth($arCells[$n][8]));
	}

	if (DoubleVal($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["DISCOUNT_VALUE"]) > 0)
	{
		$arCells[++$n] = array(
			1 => null,
			null,
			null,
			null,
			null,
			null,
			CSalePdf::prepareToPdf("Скидка:"),
			CSalePdf::prepareToPdf(SaleFormatCurrency(
				$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["DISCOUNT_VALUE"],
				$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"],
				true
			))
		);

		$arRowsWidth[8] = max($arRowsWidth[8], $pdf->GetStringWidth($arCells[$n][8]));
	}

	$arCells[++$n] = array(
		1 => null,
		null,
		null,
		null,
		null,
		null,
		CSalePdf::prepareToPdf("Итого:"),
		CSalePdf::prepareToPdf(SaleFormatCurrency(
			$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["SHOULD_PAY"],
			$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"],
			true
		))
	);

	$arRowsWidth[8] = max($arRowsWidth[8], $pdf->GetStringWidth($arCells[$n][8]));

	for ($i = 1; $i <= 8; $i++)
		$arRowsWidth[$i] += 10;
	if (!$bShowDiscount)
		$arRowsWidth[6] = 0;
	if ($vat <= 0)
		$arRowsWidth[7] = 0;
	$arRowsWidth[2] = $width - (array_sum($arRowsWidth)-$arRowsWidth[2]);
}
$pdf->Ln();

$x0 = $pdf->GetX();
$y0 = $pdf->GetY();

for ($i = 1; $i <= 8; $i++)
{
	if (($bShowDiscount || $i !== 6) && ($vat > 0 || $i !== 7))
		$pdf->Cell($arRowsWidth[$i], 20, $arColsCaption[$i], 0, 0, 'C');
	${"x$i"} = $pdf->GetX();
}

$pdf->Ln();

$y5 = $pdf->GetY();

$pdf->Line($x0, $y0, $x8, $y0);
for ($i = 0; $i <= 8; $i++)
{
	if (($bShowDiscount || $i !== 6) && ($vat > 0 || $i !== 7))
		$pdf->Line(${"x$i"}, $y0, ${"x$i"}, $y5);
}
$pdf->Line($x0, $y5, $x8, $y5);

$rowsCnt = count($arCells);
for ($n = 1; $n <= $rowsCnt; $n++)
{
	$arRowsWidth_tmp = $arRowsWidth;
	$accumulated = 0;
	for ($j = 1; $j <= 8; $j++)
	{
		if (is_null($arCells[$n][$j]))
		{
			$accumulated += $arRowsWidth_tmp[$j];
			$arRowsWidth_tmp[$j] = null;
		}
		else
		{
			$arRowsWidth_tmp[$j] += $accumulated;
			$accumulated = 0;
		}
	}

	$x0 = $pdf->GetX();
	$y0 = $pdf->GetY();

	$pdf->SetFont($fontFamily, '', $fontSize);

	if (!is_null($arCells[$n][2]))
	{
		$text = $arCells[$n][2];
		$cellWidth = $arRowsWidth_tmp[2];
	}
	else
	{
		$text = $arCells[$n][7];
		$cellWidth = $arRowsWidth_tmp[7];
	}

	for ($l = 0; $pdf->GetStringWidth($text) > 0; $l++)
	{
		list($string, $text) = $pdf->splitString($text, $cellWidth-5);

		if (!is_null($arCells[$n][1]))
			$pdf->Cell($arRowsWidth_tmp[1], 15, ($l == 0) ? $arCells[$n][1] : '', 0, 0, 'C');
		if ($l == 0)
			$x1 = $pdf->GetX();

		if (!is_null($arCells[$n][2]))
			$pdf->Cell($arRowsWidth_tmp[2], 15, $string);
		if ($l == 0)
			$x2 = $pdf->GetX();

		if (!is_null($arCells[$n][3]))
			$pdf->Cell($arRowsWidth_tmp[3], 15, ($l == 0) ? $arCells[$n][3] : '', 0, 0, 'R');
		if ($l == 0)
			$x3 = $pdf->GetX();

		if (!is_null($arCells[$n][4]))
			$pdf->Cell($arRowsWidth_tmp[4], 15, ($l == 0) ? $arCells[$n][4] : '', 0, 0, 'R');
		if ($l == 0)
			$x4 = $pdf->GetX();

		if (!is_null($arCells[$n][5]))
			$pdf->Cell($arRowsWidth_tmp[5], 15, ($l == 0) ? $arCells[$n][5] : '', 0, 0, 'R');
		if ($l == 0)
			$x5 = $pdf->GetX();

		if (!is_null($arCells[$n][6]))
		{
			if (is_null($arCells[$n][2]))
				$pdf->Cell($arRowsWidth_tmp[6], 15, $string, 0, 0, 'R');
			else if ($bShowDiscount)
				$pdf->Cell($arRowsWidth_tmp[6], 15, ($l == 0) ? $arCells[$n][6] : '', 0, 0, 'R');
		}
		if ($l == 0)
			$x6 = $pdf->GetX();

		if (!is_null($arCells[$n][7]))
		{
			if (is_null($arCells[$n][2]))
				$pdf->Cell($arRowsWidth_tmp[7], 15, $string, 0, 0, 'R');
			else if ($vat > 0)
				$pdf->Cell($arRowsWidth_tmp[7], 15, ($l == 0) ? $arCells[$n][7] : '', 0, 0, 'R');
		}
		if ($l == 0)
			$x7 = $pdf->GetX();

		if (!is_null($arCells[$n][8]))
			$pdf->Cell($arRowsWidth_tmp[8], 15, ($l == 0) ? $arCells[$n][8] : '', 0, 0, 'R');
		if ($l == 0)
			$x8 = $pdf->GetX();

		$pdf->Ln();
	}

	if (isset($arProps[$n]) && is_array($arProps[$n]))
	{
		$pdf->SetFont($fontFamily, '', $fontSize-2);
		foreach ($arProps[$n] as $property)
		{
			$pdf->Cell($arRowsWidth_tmp[1], 12, '');
			$pdf->Cell($arRowsWidth_tmp[2], 12, $property);
			$pdf->Cell($arRowsWidth_tmp[3], 12, '');
			$pdf->Cell($arRowsWidth_tmp[4], 12, '');
			$pdf->Cell($arRowsWidth_tmp[5], 12, '');
			if ($bShowDiscount)
				$pdf->Cell($arRowsWidth_tmp[6], 12, '');
			if ($vat > 0)
				$pdf->Cell($arRowsWidth_tmp[7], 12, '');
			$pdf->Cell($arRowsWidth_tmp[8], 12, '', 0, 1);
		}
	}

	$y5 = $pdf->GetY();

	if ($y0 > $y5)
		$y0 = $margin['top'];
	for ($i = (is_null($arCells[$n][1])) ? 7 : 0; $i <= 8; $i++)
	{
		if ($vat > 0 || $i != 6)
			$pdf->Line(${"x$i"}, $y0, ${"x$i"}, $y5);
	}

	$pdf->Line((!is_null($arCells[$n][1])) ? $x0 : $x7, $y5, $x8, $y5);
}
$pdf->Ln();


$pdf->SetFont($fontFamily, '', $fontSize);
$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(
	"Всего наименований %s, на сумму %s",
	$items,
	SaleFormatCurrency(
		$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["SHOULD_PAY"],
		$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"],
		false
	)
)));
$pdf->Ln();

$pdf->SetFont($fontFamily, 'B', $fontSize);
if (in_array($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"], array("RUR", "RUB")))
{
	$pdf->Write(15, CSalePdf::prepareToPdf(Number2Word_Rus($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["SHOULD_PAY"])));
}
else
{
	$pdf->Write(15, CSalePdf::prepareToPdf(SaleFormatCurrency(
		$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["SHOULD_PAY"],
		$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"],
		false
	)));
}
$pdf->Ln();

$sellerInfo = array(
	'NAME' => CSalePaySystemAction::GetParamValue("SELLER_NAME", false),
	'ADDRESS' => CSalePaySystemAction::GetParamValue("SELLER_ADDRESS", false),
	'PHONE' => CSalePaySystemAction::GetParamValue("SELLER_PHONE", false),
	'INN' => CSalePaySystemAction::GetParamValue("SELLER_INN", false),
	'KPP' => CSalePaySystemAction::GetParamValue("SELLER_KPP", false),
	'RS' => CSalePaySystemAction::GetParamValue("SELLER_RS", false),
	'BANK' => CSalePaySystemAction::GetParamValue("SELLER_BANK", false),
	'BIK' => CSalePaySystemAction::GetParamValue("SELLER_BIK", false),
	'BANK_CITY' => CSalePaySystemAction::GetParamValue("SELLER_BCITY", false),
	'KS' => CSalePaySystemAction::GetParamValue("SELLER_KS", false),

);

$customerInfo = array(
	'NAME' => CSalePaySystemAction::GetParamValue("BUYER_NAME", false),
	'ADDRESS' => CSalePaySystemAction::GetParamValue("BUYER_ADDRESS", false),
	'PHONE' => CSalePaySystemAction::GetParamValue("BUYER_PHONE", false),
	'INN' => CSalePaySystemAction::GetParamValue("BUYER_INN", false)
);

$pdf->Ln();
$pdf->Ln();

$pdf->SetFont($fontFamily, 'B', $fontSize);

$x0 = $pdf->GetX();
$y0 = $pdf->GetY();

if($sellerInfo['NAME'] || $customerInfo['NAME'])
{
	$colWidth = $width / 2;
	$nameWidth = $colWidth - 5;
	$pdf->MultiCell($nameWidth, 18, CSalePdf::prepareToPdf($sellerInfo['NAME']), 0, 'L');
	$lastY = $pdf->GetX();
	$pdf->SetXY($x0 + $colWidth + 5, $y0);
	$pdf->MultiCell($nameWidth, 18, CSalePdf::prepareToPdf($customerInfo['NAME']), 0, 'L');
	$pdf->SetXY($x0, max($lastY, $pdf->GetY()));
	unset($colWidth, $nameWidth, $lastY);
}

$pdf->SetFont($fontFamily, 'B', $fontSize);

if($sellerInfo['ADDRESS'] || $customerInfo['ADDRESS'])
{
	$pdf->Ln();

	$sellerAddressParts = array();
	$text = $sellerInfo['ADDRESS'] ? CSalePdf::prepareToPdf('Адрес: '.$sellerInfo['ADDRESS']) : '';
	for ($l = 0; $pdf->GetStringWidth($text) > 0; $l++)
	{
		list($string, $text) = $pdf->splitString($text, 250);
		$sellerAddressParts[] = $string;
	}

	$customerAddressParts = array();
	$text = $customerInfo['ADDRESS'] ? CSalePdf::prepareToPdf('Адрес: '.$customerInfo['ADDRESS']) : '';
	for ($l = 0; $pdf->GetStringWidth($text) > 0; $l++)
	{
		list($string, $text) = $pdf->splitString($text, 250);
		$customerAddressParts[] = $string;
	}

	$addressRowCnt = max(count($sellerAddressParts), count($customerAddressParts));
	for($i = 0; $i < $addressRowCnt; $i++)
	{
		$pdf->Cell(280, 18, isset($sellerAddressParts[$i]) ? $sellerAddressParts[$i] : '');
		$pdf->Cell(280, 18, isset($customerAddressParts[$i]) ? $customerAddressParts[$i] : '');
		$pdf->Ln();
	}
}

$pdf->SetFont($fontFamily, '', $fontSize);

if($sellerInfo['PHONE'] || $customerInfo['PHONE'])
{
	$pdf->Ln();
	__CrmPaySysQuoteDrawFieldCell($sellerInfo, 'PHONE', 'Телефон: ', 280, 18, $pdf);
	__CrmPaySysQuoteDrawFieldCell($customerInfo, 'PHONE', 'Телефон: ', 280, 18, $pdf);
}

if($sellerInfo['INN'] || $customerInfo['INN'])
{
	$pdf->Ln();
	__CrmPaySysQuoteDrawFieldCell($sellerInfo, 'INN', 'ИНН: ', 280, 18, $pdf);
	__CrmPaySysQuoteDrawFieldCell($customerInfo, 'INN', 'ИНН: ', 280, 18, $pdf);
}

if($sellerInfo['KPP'])
{
	$pdf->Ln();
	__CrmPaySysQuoteDrawFieldCell($sellerInfo, 'KPP', 'КПП: ', 280, 18, $pdf);
}

if($sellerInfo['RS'])
{
	$pdf->Ln();
	__CrmPaySysQuoteDrawFieldCell($sellerInfo, 'RS', 'Расчётный счёт: ', 280, 18, $pdf);
}

if($sellerInfo['BANK'])
{
	$bankName = $sellerInfo['BANK'];
	if($sellerInfo['BANK_CITY'])
	{
		$bankName .= ', ';
		$bankName .= $sellerInfo['BANK_CITY'];
	}
	list($string, $text) = $pdf->splitString(CSalePdf::prepareToPdf('Банк: '.$bankName), 500);
	$pdf->Ln();
	$pdf->Cell(500, 18, $string);
}

if($sellerInfo['BIK'])
{
	$pdf->Ln();
	__CrmPaySysQuoteDrawFieldCell($sellerInfo, 'BIK', 'БИК: ', 280, 18, $pdf);
}

if($sellerInfo['KS'])
{
	$pdf->Ln();
	__CrmPaySysQuoteDrawFieldCell($sellerInfo, 'KS', 'Корреспондентский счет: ', 280, 18, $pdf);
}

$pdf->Ln();

if (!$blank && CSalePaySystemAction::GetParamValue('PATH_TO_STAMP', false))
{
	list($stampHeight, $stampWidth) = $pdf->GetImageSize(CSalePaySystemAction::GetParamValue('PATH_TO_STAMP', false));

	if ($stampHeight && $stampWidth)
	{
		if ($stampHeight > 120 || $stampWidth > 120)
		{
			$ratio = 120 / max($stampHeight, $stampWidth);
			$stampHeight = $ratio * $stampHeight;
			$stampWidth  = $ratio * $stampWidth;
		}

		$pdf->Image(
			CSalePaySystemAction::GetParamValue('PATH_TO_STAMP', false),
			$margin['left']+40, $pdf->GetY(),
			$stampWidth, $stampHeight
		);
	}
}
$pdf->Ln();

$pdf->SetFont($fontFamily, 'B', $fontSize);

if (CSalePaySystemAction::GetParamValue("SELLER_DIR_POS", false))
{
	$isDirSign = false;
	if (!$blank && CSalePaySystemAction::GetParamValue('SELLER_DIR_SIGN', false))
	{
		list($signHeight, $signWidth) = $pdf->GetImageSize(CSalePaySystemAction::GetParamValue('SELLER_DIR_SIGN', false));

		if ($signHeight && $signWidth)
		{
			$ratio = min(37.5/$signHeight, 150/$signWidth);
			$signHeight = $ratio * $signHeight;
			$signWidth  = $ratio * $signWidth;

			$isDirSign = true;
		}
	}

	$sellerDirPos = CSalePdf::prepareToPdf(CSalePaySystemAction::GetParamValue("SELLER_DIR_POS", false));
	if ($isDirSign && $pdf->GetStringWidth($sellerDirPos) <= 160)
		$pdf->SetY($pdf->GetY() + min($signHeight, 30) - 15);
	$pdf->MultiCell(150, 15, $sellerDirPos, 0, 'L');
	$pdf->SetXY($margin['left'] + 150, $pdf->GetY() - 15);

	if ($isDirSign)
	{
		$pdf->Image(
			CSalePaySystemAction::GetParamValue('SELLER_DIR_SIGN', false),
			$pdf->GetX() + 80 - $signWidth/2, $pdf->GetY() - $signHeight + 15,
			$signWidth, $signHeight
		);
	}

	$x1 = $pdf->GetX();
	$pdf->Cell(160, 15, '');
	$x2 = $pdf->GetX();

	if (CSalePaySystemAction::GetParamValue("SELLER_DIR", false))
		$pdf->Write(15, CSalePdf::prepareToPdf('('.CSalePaySystemAction::GetParamValue("SELLER_DIR", false).')'));
	$pdf->Ln();

	$y2 = $pdf->GetY();
	$pdf->Line($x1, $y2, $x2, $y2);

	$pdf->Ln();
}

if (CSalePaySystemAction::GetParamValue("SELLER_ACC_POS", false))
{
	$isAccSign = false;
	if (!$blank && CSalePaySystemAction::GetParamValue('SELLER_ACC_SIGN', false))
	{
		list($signHeight, $signWidth) = $pdf->GetImageSize(CSalePaySystemAction::GetParamValue('SELLER_ACC_SIGN', false));

		if ($signHeight && $signWidth)
		{
			$ratio = min(37.5/$signHeight, 150/$signWidth);
			$signHeight = $ratio * $signHeight;
			$signWidth  = $ratio * $signWidth;

			$isAccSign = true;
		}
	}

	$sellerAccPos = CSalePdf::prepareToPdf(CSalePaySystemAction::GetParamValue("SELLER_ACC_POS", false));
	if ($isAccSign && $pdf->GetStringWidth($sellerAccPos) <= 160)
		$pdf->SetY($pdf->GetY() + min($signHeight, 30) - 15);
	$pdf->MultiCell(150, 15, $sellerAccPos, 0, 'L');
	$pdf->SetXY($margin['left'] + 150, $pdf->GetY() - 15);

	if ($isAccSign)
	{
		$pdf->Image(
			CSalePaySystemAction::GetParamValue('SELLER_ACC_SIGN', false),
			$pdf->GetX() + 80 - $signWidth/2, $pdf->GetY() - $signHeight + 15,
			$signWidth, $signHeight
		);
	}

	$x1 = $pdf->GetX();
	$pdf->Cell((CSalePaySystemAction::GetParamValue("SELLER_DIR", false)) ? $x2-$x1 : 160, 15, '');
	$x2 = $pdf->GetX();

	if (CSalePaySystemAction::GetParamValue("SELLER_ACC", false))
		$pdf->Write(15, CSalePdf::prepareToPdf('('.CSalePaySystemAction::GetParamValue("SELLER_ACC", false).')'));
	$pdf->Ln();

	$y2 = $pdf->GetY();
	$pdf->Line($x1, $y2, $x2, $y2);
}


$dest = 'I';
if ($_REQUEST['GET_CONTENT'] == 'Y')
	$dest = 'S';
else if ($_REQUEST['DOWNLOAD'] == 'Y')
	$dest = 'D';

return $pdf->Output(
	sprintf(
		'Quote No %s ot %s.pdf',
		$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["ACCOUNT_NUMBER"],
		ConvertDateTime($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["DATE_INSERT"], 'YYYY-MM-DD')
	), $dest
);
?>