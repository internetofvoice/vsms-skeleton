<?php

namespace Acme\Skill\Service;

use InternetOfVoice\VSMS\Core\Service\AbstractService;

/**
 * ExampleService
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */

class ExampleService extends AbstractService
{
	private static $capitals = [
		'en' => [
			"Abkhazia" => "Sukhumi",
			"Afghanistan" => "Kabul",
			"Akrotiri and Dhekelia" => "Episkopi Cantonment",
			"Albania" => "Tirana",
			"Algeria" => "Algiers",
			"American Samoa" => "Pago Pago",
			"Andorra" => "Andorra la Vella",
			"Angola" => "Luanda",
			"Anguilla" => "The Valley",
			"Antigua and Barbuda" => "St. John's",
			"Argentina" => "Buenos Aires",
			"Armenia" => "Yerevan",
			"Aruba" => "Oranjestad",
			"Ascension Island" => "Georgetown",
			"Australia" => "Canberra",
			"Austria" => "Vienna",
			"Azerbaijan" => "Baku",
			"Bahamas" => "Nassau",
			"Bahrain" => "Manama",
			"Bangladesh" => "Dhaka",
			"Barbados" => "Bridgetown",
			"Belarus" => "Minsk",
			"Belgium" => "Brussels",
			"Belize" => "Belmopan",
			"Benin" => "Porto-Novo",
			"Bermuda" => "Hamilton",
			"Bhutan" => "Thimphu",
			"Bolivia" => "La Paz",
			"Bosnia and Herzegovina" => "Sarajevo",
			"Botswana" => "Gaborone",
			"Brazil" => "Brasília",
			"British Virgin Islands" => "Road Town",
			"Brunei" => "Bandar Seri Begawan",
			"Bulgaria" => "Sofia",
			"Burkina Faso" => "Ouagadougou",
			"Burundi" => "Bujumbura",
			"Cambodia" => "Phnom Penh",
			"Cameroon" => "Yaoundé",
			"Canada" => "Ottawa",
			"Canary Islands" => "Santa Cruz de Tenerife and Las Palmas de Gran Canaria",
			"Cape Verde" => "Praia",
			"Cayman Islands" => "George Town",
			"Central African Republic" => "Bangui",
			"Chad" => "N'Djamena",
			"Chechnya" => "Grozny",
			"Chile" => "Santiago",
			"China" => "Beijing",
			"Christmas Island" => "Flying Fish Cove",
			"Cocos Islands" => "West Island",
			"Colombia" => "Bogotá",
			"Comoros" => "Moroni",
			"Congo" => "Brazzaville",
			"Cook Islands" => "Avarua",
			"Costa Rica" => "San José",
			"Côte d'Ivoire" => "Yamoussoukro",
			"Croatia" => "Zagreb",
			"Cuba" => "Havana",
			"Curaçao" => "Willemstad",
			"Cyprus" => "Nicosia",
			"Czech Republic" => "Prague",
			"Democratic Republic of the Congo" => "Kinshasa",
			"Denmark" => "Copenhagen",
			"Djibouti" => "Djibouti",
			"Dominica" => "Roseau",
			"Dominican Republic" => "Santo Domingo",
			"East Timor" => "Dili",
			"Easter Island" => "Hanga Roa",
			"Ecuador" => "Quito",
			"Egypt" => "Cairo",
			"El Salvador" => "San Salvador",
			"Equatorial Guinea" => "Malabo",
			"Eritrea" => "Asmara",
			"Estonia" => "Tallinn",
			"Ethiopia" => "Addis Ababa",
			"Falkland Islands" => "Stanley",
			"Faroe Islands" => "Tórshavn",
			"Fiji" => "Suva",
			"Finland" => "Helsinki",
			"France" => "Paris",
			"French Guiana" => "Cayenne",
			"French Polynesia" => "Papeete",
			"Gabon" => "Libreville",
			"Gambia" => "Banjul",
			"Georgia" => "Tbilisi",
			"Germany" => "Berlin",
			"Ghana" => "Accra",
			"Gibraltar" => "Gibraltar",
			"Greece" => "Athens",
			"Greenland" => "Nuuk",
			"Grenada" => "St. George's",
			"Guadeloupe" => "Basse-Terre",
			"Guam" => "Hagåtña",
			"Guatemala" => "Guatemala City",
			"Guernsey" => "St. Peter Port",
			"Guinea" => "Conakry",
			"Guinea-Bissau" => "Bissau",
			"Guyana" => "Georgetown",
			"Haiti" => "Port-au-Prince",
			"Honduras" => "Tegucigalpa",
			"Hong Kong" => "Hong Kong",
			"Hungary" => "Budapest",
			"Iceland" => "Reykjavík",
			"India" => "New Delhi",
			"Indonesia" => "Jakarta",
			"Iran" => "Tehran",
			"Iraq" => "Baghdad",
			"Ireland" => "Dublin",
			"Isle of Man" => "Douglas",
			"Israel" => "Jerusalem",
			"Italy" => "Rome",
			"Jamaica" => "Kingston",
			"Japan" => "Tokyo",
			"Jersey" => "St. Helier",
			"Jordan" => "Amman",
			"Kazakhstan" => "Astana",
			"Kenya" => "Nairobi",
			"Kiribati" => "Tarawa",
			"Kosovo" => "Pristina",
			"Kuwait" => "Kuwait City",
			"Kyrgyzstan" => "Bishkek",
			"Laos" => "Vientiane",
			"Latvia" => "Riga",
			"Lebanon" => "Beirut",
			"Lesotho" => "Maseru",
			"Liberia" => "Monrovia",
			"Libya" => "Tripoli",
			"Liechtenstein" => "Vaduz",
			"Lithuania" => "Vilnius",
			"Luxembourg" => "Luxembourg",
			"Macedonia" => "Skopje",
			"Madagascar" => "Antananarivo",
			"Malawi" => "Lilongwe",
			"Malaysia" => "Kuala Lumpur",
			"Maldives" => "Malé",
			"Mali" => "Bamako",
			"Malta" => "Valletta",
			"Marshall Islands" => "Majuro",
			"Martinique" => "Fort-de-France",
			"Mauritania" => "Nouakchott",
			"Mauritius" => "Port Louis",
			"Mayotte" => "Mamoudzou",
			"Mexico" => "Mexico City",
			"Micronesia" => "Palikir",
			"Moldova" => "Chișinău",
			"Monaco" => "Monaco",
			"Mongolia" => "Ulaanbaatar",
			"Montenegro" => "Podgorica",
			"Montserrat" => "Plymouth",
			"Morocco" => "Rabat",
			"Mozambique" => "Maputo",
			"Myanmar" => "Naypyidaw",
			"Nagorno-Karabakh" => "Stepanakert",
			"Namibia" => "Windhoek",
			"Nauru" => "Yaren",
			"Nepal" => "Kathmandu",
			"Netherlands" => "Amsterdam",
			"New Caledonia" => "Nouméa",
			"New Zealand" => "Wellington",
			"Nicaragua" => "Managua",
			"Niger" => "Niamey",
			"Nigeria" => "Abuja",
			"Niue" => "Alofi",
			"Norfolk Island" => "Kingston",
			"North Korea" => "Pyongyang",
			"Northern Cyprus" => "Nicosia",
			"Northern Mariana Islands" => "Saipan",
			"Norway" => "Oslo",
			"Oman" => "Muscat",
			"Pakistan" => "Islamabad",
			"Palau" => "Ngerulmud",
			"Palestine" => "Ramallah",
			"Panama" => "Panama City",
			"Papua New Guinea" => "Port Moresby",
			"Paraguay" => "Asunción",
			"Peru" => "Lima",
			"Philippines" => "Manila",
			"Pitcairn" => "Adamstown",
			"Poland" => "Warsaw",
			"Portugal" => "Lisbon",
			"Puerto Rico" => "San Juan",
			"Qatar" => "Doha",
			"Réunion" => "Saint-Denis",
			"Romania" => "Bucharest",
			"Russia" => "Moscow",
			"Rwanda" => "Kigali",
			"Sahrawi" => "Laayoune",
			"Saint Barthélemy" => "Gustavia",
			"Saint Helena" => "Jamestown",
			"Saint Kitts and Nevis" => "Basseterre",
			"Saint Lucia" => "Castries",
			"Saint Martin" => "Marigot",
			"Saint Pierre and Miquelon" => "St. Pierre",
			"Saint Vincent and the Grenadines" => "Kingstown",
			"Samoa" => "Apia",
			"San Marino" => "San Marino",
			"São Tomé and Príncipe" => "São Tomé",
			"Saudi Arabia" => "Riyadh",
			"Senegal" => "Dakar",
			"Serbia" => "Belgrade",
			"Seychelles" => "Victoria",
			"Sierra Leone" => "Freetown",
			"Singapore" => "Singapore",
			"Sint Maarten" => "Philipsburg",
			"Slovakia" => "Bratislava",
			"Slovenia" => "Ljubljana",
			"Solomon Islands" => "Honiara",
			"Somalia" => "Mogadishu",
			"Somaliland" => "Hargeisa",
			"South Africa" => "Cape Town",
			"South Georgia and the South Sandwich Islands" => "King Edward Point",
			"South Korea" => "Seoul",
			"South Ossetia" => "Tskhinvali",
			"South Sudan" => "Juba",
			"Spain" => "Madrid",
			"Sri Lanka" => "Colombo",
			"Sudan" => "Khartoum",
			"Suriname" => "Paramaribo",
			"Swaziland" => "Lobamba",
			"Sweden" => "Stockholm",
			"Switzerland" => "Bern",
			"Syria" => "Damascus",
			"Taiwan" => "Taipei",
			"Tajikistan" => "Dushanbe",
			"Tanzania" => "Dodoma",
			"Thailand" => "Bangkok",
			"Togo" => "Lomé",
			"Tonga" => "Nukuʻalofa",
			"Transnistria" => "Tiraspol",
			"Trinidad and Tobago" => "Port of Spain",
			"Tristan da Cunha" => "Edinburgh of the Seven Seas",
			"Tunisia" => "Tunis",
			"Turkey" => "Ankara",
			"Turkmenistan" => "Ashgabat",
			"Turks and Caicos Islands" => "Cockburn Town",
			"Tuvalu" => "Funafuti",
			"Uganda" => "Kampala",
			"Ukraine" => "Kiev",
			"United Arab Emirates" => "Abu Dhabi",
			"United Kingdom" => "London",
			"United States" => "Washington D.C.",
			"United States Virgin Islands" => "Charlotte Amalie",
			"Uruguay" => "Montevideo",
			"Uzbekistan" => "Tashkent",
			"Vanuatu" => "Port Vila",
			"Vatican City" => "Vatican City",
			"Venezuela" => "Caracas",
			"Vietnam" => "Hanoi",
			"Wallis and Futuna" => "Mata-Utu",
			"Yemen" => "Sana",
			"Zambia" => "Lusaka",
			"Zimbabwe" => "Harare",
        ],

        'de' => [
            'Afghanistan' => 'Kabul',
            'Ägypten' => 'Kairo',
            'Albanien' => 'Tirana',
            'Algerien' => 'Algier',
            'Andorra' => 'Andorra la Vella',
            'Angola' => 'Luanda',
            'Antigua und Barbuda' => 'St. John’s',
            'Äquatorialguinea' => 'Malabo',
            'Argentinien' => 'Buenos Aires',
            'Armenien' => 'Jerewan',
            'Aserbaidschan' => 'Baku',
            'Äthiopien' => 'Addis Abeba',
            'Australien' => 'Canberra',
            'Bahamas' => 'Nassau',
            'Bahrain' => 'Manama',
            'Bangladesch' => 'Dhaka',
            'Barbados' => 'Bridgetown',
            'Belgien' => 'Brüssel',
            'Belize' => 'Belmopan',
            'Benin' => 'Porto Novo',
            'Bhutan' => 'Thimphu',
            'Bolivien' => 'La Paz',
            'Bosnien und Herzegowina' => 'Sarajevo',
            'Botswana' => 'Gaborone',
            'Brasilien' => 'Brasília',
            'Brunei' => 'Bandar Seri Begawan',
            'Bulgarien' => 'Sofia',
            'Burkina Faso' => 'Ouagadougou',
            'Burundi' => 'Bujumbura',
            'Chile' => 'Santiago de Chile',
            'Taiwan' => 'Taipeh',
            'China' => 'Peking',
            'Cookinseln' => 'Avarua',
            'Costa Rica' => 'San José',
            'Dänemark' => 'Kopenhagen',
            'Deutschland' => 'Berlin',
            'Dominica' => 'Roseau',
            'Dominikanische Republik' => 'Santo Domingo',
            'Dschibuti' => 'Dschibuti',
            'Ecuador' => 'Quito',
            'Elfenbeinküste' => 'Yamoussoukro',
            'El Salvador' => 'San Salvador',
            'Eritrea' => 'Asmara',
            'Estland' => 'Tallinn',
            'Fidschi' => 'Suva',
            'Finnland' => 'Helsinki',
            'Frankreich' => 'Paris',
            'Gabun' => 'Libreville',
            'Gambia' => 'Banjul',
            'Georgien' => 'Tiflis',
            'Ghana' => 'Accra',
            'Grenada' => 'St. George’s',
            'Griechenland' => 'Athen',
            'Guatemala' => 'Guatemala-Stadt',
            'Guinea' => 'Conakry',
            'Guinea-Bissau' => 'Bissau',
            'Guyana' => 'Georgetown',
            'Haiti' => 'Port-au-Prince',
            'Honduras' => 'Tegucigalpa',
            'Indien' => 'Neu-Delhi',
            'Indonesien' => 'Jakarta',
            'Irak' => 'Bagdad',
            'Iran' => 'Teheran',
            'Irland' => 'Dublin',
            'Island' => 'Reykjavík',
            'Israel' => 'Jerusalem',
            'Italien' => 'Rom',
            'Jamaika' => 'Kingston',
            'Japan' => 'Tokio',
            'Jemen' => 'Sanaa',
            'Jordanien' => 'Amman',
            'Kambodscha' => 'Phnom Penh',
            'Kamerun' => 'Yaoundé',
            'Kanada' => 'Ottawa',
            'Kap Verde' => 'Praia',
            'Kasachstan' => 'Astana',
            'Katar' => 'Doha',
            'Kenia' => 'Nairobi',
            'Kirgisistan' => 'Bischkek',
            'Kiribati' => 'South Tarawa',
            'Kolumbien' => 'Bogotá',
            'Komoren' => 'Moroni',
            'Demokratische Republik Kongo' => 'Kinshasa',
            'Kongo' => 'Brazzaville',
            'Nordkorea' => 'Pjöngjang',
            'Südkorea' => 'Seoul',
            'Kosovo' => 'Priština',
            'Kroatien' => 'Zagreb',
            'Kuba' => 'Havanna',
            'Kuwait' => 'Kuwait-Stadt',
            'Laos' => 'Vientiane',
            'Lesotho' => 'Maseru',
            'Lettland' => 'Riga',
            'Libanon' => 'Beirut',
            'Liberia' => 'Monrovia',
            'Libyen' => 'Tripolis',
            'Liechtenstein' => 'Vaduz',
            'Litauen' => 'Vilnius',
            'Luxemburg' => 'Luxemburg',
            'Madagaskar' => 'Antananarivo',
            'Malawi' => 'Lilongwe',
            'Malaysia' => 'Kuala Lumpur',
            'Malediven' => 'Malé',
            'Mali' => 'Bamako',
            'Malta' => 'Valletta',
            'Marokko' => 'Rabat',
            'Marshallinseln' => 'Majuro',
            'Mauretanien' => 'Nouakchott',
            'Mauritius' => 'Port Louis',
            'Mazedonien' => 'Skopje',
            'Mexiko' => 'Mexiko-Stadt',
            'Mikronesien' => 'Palikir',
            'Moldawien' => 'Chișinău',
            'Monaco' => 'Monaco',
            'Mongolei' => 'Ulaanbaatar',
            'Montenegro' => 'Podgorica',
            'Mosambik' => 'Maputo',
            'Myanmar' => 'Naypyidaw',
            'Namibia' => 'Windhoek',
            'Nauru' => 'Yaren',
            'Nepal' => 'Kathmandu',
            'Neuseeland' => 'Wellington',
            'Nicaragua' => 'Managua',
            'Niederlande' => 'Amsterdam',
            'Niger' => 'Niamey',
            'Nigeria' => 'Abuja',
            'Niue' => 'Alofi',
            'Norwegen' => 'Oslo',
            'Oman' => 'Maskat',
            'Österreich' => 'Wien',
            'Osttimor' => 'Dili',
            'Pakistan' => 'Islamabad',
            'Palau' => 'Ngerulmud',
            'Panama' => 'Panama-Stadt',
            'Papua-Neuguinea' => 'Port Moresby',
            'Paraguay' => 'Asunción',
            'Peru' => 'Lima',
            'Philippinen' => 'Manila',
            'Polen' => 'Warschau',
            'Portugal' => 'Lissabon',
            'Ruanda' => 'Kigali',
            'Rumänien' => 'Bukarest',
            'Russland' => 'Moskau',
            'Salomonen' => 'Honiara',
            'Sambia' => 'Lusaka',
            'Samoa' => 'Apia',
            'San Marino' => 'San Marino',
            'São Tomé und Príncipe' => 'São Tomé',
            'Saudi-Arabien' => 'Riad',
            'Schweden' => 'Stockholm',
            'Schweiz' => 'Bern',
            'Senegal' => 'Dakar',
            'Serbien' => 'Belgrad',
            'Seychellen' => 'Victoria',
            'Sierra Leone' => 'Freetown',
            'Simbabwe' => 'Harare',
            'Singapur' => 'Singapur',
            'Slowakei' => 'Bratislava',
            'Slowenien' => 'Ljubljana',
            'Somalia' => 'Mogadischu',
            'Spanien' => 'Madrid',
            'Sri Lanka' => 'Sri Jayewardenepura',
            'St. Kitts und Nevis' => 'Basseterre',
            'St. Lucia' => 'Castries',
            'St. Vincent und die Grenadinen' => 'Kingstown',
            'Südafrika' => 'Pretoria',
            'Südsudan' => 'Juba',
            'Sudan' => 'Khartum',
            'Suriname' => 'Paramaribo',
            'Swasiland' => 'Mbabane',
            'Syrien' => 'Damaskus',
            'Tadschikistan' => 'Duschanbe',
            'Tansania' => 'Daressalam',
            'Thailand' => 'Bangkok',
            'Togo' => 'Lomé',
            'Tonga' => 'Nukuʻalofa',
            'Trinidad und Tobago' => 'Port of Spain',
            'Tschad' => 'N’Djamena',
            'Tschechien' => 'Prag',
            'Tunesien' => 'Tunis',
            'Türkei' => 'Ankara',
            'Turkmenistan' => 'Aşgabat',
            'Tuvalu' => 'Funafuti',
            'Uganda' => 'Kampala',
            'Ukraine' => 'Kiew',
            'Ungarn' => 'Budapest',
            'Uruguay' => 'Montevideo',
            'Usbekistan' => 'Taschkent',
            'Vanuatu' => 'Port Vila',
            'Vatikanstadt' => 'Vatikanstadt',
            'Venezuela' => 'Caracas',
            'Vereinigte Arabische Emirate' => 'Abu Dhabi',
            'Vereinigtes Königreich' => 'London',
            'USA' => 'Washington',
            'Vietnam' => 'Hanoi',
            'Weißrussland' => 'Minsk',
            'Westsahara' => 'El Aaiún',
            'Zentralafrikanische Republik' => 'Bangui',
            'Zypern' => 'Nikosia',
            'Türkische Republik Nord-Zypern' => 'Nord-Nikosia',
        ],
	];

	/**
	 * getCapital
	 *
	 * @param   string		$language		The language to retrieve capital for
	 * @param   string		$country		Country to retrieve capital for
	 * @return  false|string
	 * @access	public
	 * @author	a.schmidt@internet-of-voice.de
	 */
	public function getCapital($language, $country) {
		if(!isset(self::$capitals[$language])) {
			return false;
		}

        // Direct match?
	    if(isset(self::$capitals[$language][$country])) {
            return self::$capitals[$language][$country];
        }

        // Alexa might supply slots in lowercase, so additionally try to match all in lowercase
        $lower_country  = mb_strtolower($country, 'UTF-8');
        $lower_capitals = array();
        foreach(self::$capitals[$language] as $key => $value) {
            $lower_capitals[mb_strtolower($key, 'UTF-8')] = $value;
        }

        if(isset($lower_capitals[$lower_country])) {
            return $lower_capitals[$lower_country];
        }

        return false;
	}
}

?>
