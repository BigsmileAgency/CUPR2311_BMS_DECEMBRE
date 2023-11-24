function dynamic_content() {
  // Enabler.setProfileId(); !!! Check common.js.php
  var devDynamicContent = {};

  if (lang == "FR") {
    devDynamicContent.AUDI1902_DCO_AOT2019_DATA_PURCHASE_FR = [{}];
    var devContent = devDynamicContent.AUDI1902_DCO_AOT2019_DATA_PURCHASE_FR[0];

    devContent.copy1 = "Audi A4 Berline àpd 385 €/mois HTVA en Renting Financier.";
    devContent.cta = "Demandez une offre";
  } else {
    devDynamicContent.AUDI1902_DCO_AOT2019_DATA_PURCHASE_NL = [{}];
    var devContent = devDynamicContent.AUDI1902_DCO_AOT2019_DATA_PURCHASE_NL[0];
    
    devContent.copy1 = "Audi A4 Berline vanaf € 385/maand excl. btw in Financiële Renting.";
    devContent.cta = "Vraag een offerte aan";
  }

  devContent._id = 0;
  devContent.image = {};
  devContent.image.Type = "file";
  devContent.image.Url = "https://s0.2mdn.net/ads/richmedia/studio/36714122/36714122_20190917053323182_300x600-01.png";
  devContent.image2 = {};
  devContent.image2.Type = "file";
  devContent.image2.Url = "https://s0.2mdn.net/ads/richmedia/studio/36714122/36714122_20190917053327075_300x600-02.png";
  devContent.image3 = {};
  devContent.image3.Type = "file";
  devContent.image3.Url = "https://s0.2mdn.net/ads/richmedia/studio/36714122/36714122_20190917053330812_300x600-03.png";
  devContent.text_color = "white";
  devContent.logo_color = "white";
  devContent.legal = "white";
  devContent.exit_url = {};
  devContent.exit_url.Url = "";
  Enabler.setDevDynamicContent(devDynamicContent);

  if (lang == "FR") {
    var prefix  = dynamicContent.AUDI1902_DCO_AOT2019_DATA_PURCHASE_FR[0];

    document.getElementById('t1').innerHTML = prefix.copy1
    .replace(' ?', '&nbsp;?')
    .replace(' €', '&nbsp;€');
  } else {
    var prefix  = dynamicContent.AUDI1902_DCO_AOT2019_DATA_PURCHASE_NL[0];

    document.getElementById('t1').innerHTML = prefix.copy1
    .replace(' ?', '&nbsp;?')
    .replace('€ ', '€&nbsp;')
    .replace('/', '/ ');
  }

	document.getElementById('visu1').src = prefix.image.Url;
	document.getElementById('visu2').src = prefix.image2.Url;
	document.getElementById('visu3').src = prefix.image3.Url;
	document.getElementById('headline').innerHTML = prefix.copy1;
	document.getElementById('subline').innerHTML = prefix.copy2;
	document.getElementById('cta_content').innerHTML = prefix.cta;

  bg_img(prefix, format);

	document.getElementById('clickThroughBtn').addEventListener('click', ctaHandler);
	function ctaHandler(){
    // Enabler.exitOverride('dynamicEXIT', prefix.exit_url.Url);
    Enabler.exitOverride('dynamicEXIT', prefix.exit_url.Url);
    Enabler.counter('Click', false);
	}
}

function bg_img(prefix, format) {
  switch (format) {
    case '160x600':
      return document.getElementById('car_bg').src = prefix.image_160x600.Url;
    case '300x600':
      return document.getElementById('car_bg').src = prefix.image_300x600.Url;
    case '300x250':
      return document.getElementById('car_bg').src = prefix.image_300x250.Url;
    case '728x90':
      return document.getElementById('car_bg').src = prefix.image_728x90.Url;
    default:
      return document.getElementById('car_bg').src = prefix.image_320x50.Url;
  }
}