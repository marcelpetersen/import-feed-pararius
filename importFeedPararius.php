<?php
// set import feed pararius url:
$url = 'http://example.com/pararius.xml';

// check if host is development or production:
$host = '';
if (isset($_SERVER['SERVER_NAME'])) {
    $host = substr($_SERVER['SERVER_NAME'], 0, 5);
}
if ($host == 'local') {
    // development:
    error_reporting(-1);
    ini_set('display_errors', '1');
    $local = TRUE;
} else {
    // production:
    error_reporting(0);
    ini_set('display_errors', '0');
    $local = FALSE;
}
// set default charset:
ini_set('default_charset', 'UTF-8');
// set no time limit:
set_time_limit(0);

// get pararius feed:
$xml = getXml($url);
if ($xml == FALSE) {
    echo 'xml error';
    exit();
}
// clean up and parse xml feed:
$xml = str_replace("&#8217;","'", $xml); // replace '.
$xml = str_replace("&#160;","", $xml); // replace nbsp.

$parsedXml = new SimpleXMLElement($xml);

// list items:
foreach ($parsedXml->member->items->item as $item) {
    echo '<pre>';
    var_dump($item);
    echo '</pre>';
    // check if isset objectId else continue:
    if (!isset($item->uniqueobjectid))        continue;
    // set vars:
    $uniqueobjectid = $item->uniqueobjectid;
    $street = (isset($item->street)) ? $item->street : '';
    $houseNumber = (isset($item->houseNumber)) ? $item->houseNumber : '';
    $houseNumberAddtion = (isset($item->houseNumberAddtion)) ? $item->houseNumberAddtion : '';
    $postalCode = (isset($item->postalCode)) ? $item->postalCode : '';
    $city = (isset($item->city)) ? $item->city : '';
    $SubArea = (isset($item->SubArea)) ? $item->SubArea : '';
    $houseType = (isset($item->houseType)) ? $item->houseType : '';
    $tenant = (isset($item->tenant)) ? $item->tenant : '';
    $estateOwner = (isset($item->estateOwner)) ? $item->estateOwner : '';
    $stats = (isset($item->stats)) ? $item->stats : '';
    $furnished = (isset($item->furnished)) ? $item->furnished : '';
    $minprice = (isset($item->minprice)) ? $item->minprice : '';
    $hideprice = (isset($item->hideprice)) ? $item->hideprice : '';
    $NroOfRooms = (isset($item->NroOfRooms)) ? $item->NroOfRooms : '';
    $NroOfLivingRooms = (isset($item->NroOfLivingRooms)) ? $item->NroOfLivingRooms : '';
    $Projectnaam = (isset($item->Projectnaam)) ? $item->Projectnaam : '';
    $WoningtypeInProject = (isset($item->WoningtypeInProject)) ? $item->WoningtypeInProject : '';
    $Available = (isset($item->Available)) ? $item->Available : '';
    $insertDate = (isset($item->insertDate)) ? $item->insertDate : '';
    $description_nl = (isset($item->description_nl)) ? $item->description_nl : '';
    $description_fr = (isset($item->description_fr)) ? $item->description_fr : '';
    $description_en = (isset($item->description_en)) ? $item->description_en : '';
    $description_de = (isset($item->description_de)) ? $item->description_de : '';
    $description_es = (isset($item->description_es)) ? $item->description_es : '';
    $description_it = (isset($item->description_it)) ? $item->description_it : '';
    $size_m2 = (isset($item->size_m2)) ? $item->size_m2 : '';
    $numberOfBathrooms = (isset($item->numberOfBathrooms)) ? $item->numberOfBathrooms : '';
    $contractLentgh_months = (isset($item->contractLentgh_months)) ? $item->contractLentgh_months : '';
    $minContractLentgh_months = (isset($item->minContractLentgh_months)) ? $item->minContractLentgh_months : '';
    $buildYear = (isset($item->buildYear)) ? $item->buildYear : '';
    $Parking = (isset($item->Parking)) ? $item->Parking : '';
    $bath = (isset($item->bath)) ? $item->bath : '';
    $separateShower = (isset($item->separateShower)) ? $item->separateShower : '';
    $separateToilet = (isset($item->separateToilet)) ? $item->separateToilet : '';
    $lift = (isset($item->lift)) ? $item->lift : '';
    $garden = (isset($item->garden)) ? $item->garden : '';
    $gardenLigging = (isset($item->gardenLigging)) ? $item->gardenLigging : '';
    $gardenSizeM2 = (isset($item->gardenSizeM2)) ? $item->gardenSizeM2 : '';
    $roofTerrass = (isset($item->roofTerrass)) ? $item->roofTerrass : '';
    $roofTerrassLigging = (isset($item->roofTerrassLigging)) ? $item->roofTerrassLigging : '';
    $roofTerrassSizeM2 = (isset($item->roofTerrassSizeM2)) ? $item->roofTerrassSizeM2 : '';
    $balcony = (isset($item->balcony)) ? $item->balcony : '';
    $BalconyLigging = (isset($item->BalconyLigging)) ? $item->BalconyLigging : '';
    $BalconySizeM2 = (isset($item->BalconySizeM2)) ? $item->BalconySizeM2 : '';
    $swimmingPool = (isset($item->swimmingPool)) ? $item->swimmingPool : '';
    $airConditioning = (isset($item->airConditioning)) ? $item->airConditioning : '';
    $firePlace = (isset($item->firePlace)) ? $item->firePlace : '';
    $garage = (isset($item->garage)) ? $item->garage : '';
    $cellar = (isset($item->cellar)) ? $item->cellar : '';
    $publicTransportQualityID = (isset($item->publicTransportQualityID)) ? $item->publicTransportQualityID : '';
    $showhouseNumber = (isset($item->showhouseNumber)) ? $item->showhouseNumber : '';
    $groundFloor = (isset($item->groundFloor)) ? $item->groundFloor : '';
    $floorQuality = (isset($item->floorQuality)) ? $item->floorQuality : '';
    $rentIncluded = (isset($item->rentIncluded)) ? $item->rentIncluded : '';
    // if not exists make dir:
    if (!is_dir('files/'.$uniqueobjectid)) {
        mkdir('files/'.$uniqueobjectid, 0777, TRUE);
    }
    // get all files:
    $brochure = (isset($item->brochure)) ? $item->brochure : FALSE;
    if ($brochure) {
        // get brochure:
        getFile($brochure, 'files/'.$uniqueobjectid);
    }
    $plattegrond = (isset($item->plattegrond)) ? $item->plattegrond : FALSE;
    if ($plattegrond) {
        // get plattegrond:
        getFile($plattegrond, 'files/'.$uniqueobjectid);
    }
    $updatePhotos = (isset($item->updatePhotos)) ? $item->updatePhotos : 0;
    if ($updatePhotos == 0)        continue;
    if (!isset($xml->photos))        continue;
    if (!isset($xml->photos->photo))        continue;
    foreach ($xml->photos->photo as $photo) {
        getFile($photo, 'files/'.$uniqueobjectid);
    }
    // set vars:
    setVars($uniqueobjectid, $street, $houseNumber, $houseNumberAddtion,
            $postalCode, $city, $SubArea, $houseType, $tenant, $estateOwner,
            $stats, $furnished, $minprice, $hideprice, $NroOfRooms,
            $NroOfLivingRooms, $Projectnaam, $WoningtypeInProject, $Available,
            $insertDate, $description_nl, $description_fr, $description_en,
            $description_de, $description_es, $description_it, $size_m2,
            $numberOfBathrooms, $contractLentgh_months,
            $minContractLentgh_months, $buildYear, $Parking, $bath,
            $separateShower, $separateToilet, $lift, $garden, $gardenLigging,
            $gardenSizeM2, $roofTerrass, $roofTerrassLigging, $roofTerrassSizeM2,
            $balcony, $BalconyLigging, $BalconySizeM2, $swimmingPool,
            $airConditioning, $firePlace, $garage, $cellar,
            $publicTransportQualityID, $showhouseNumber, $groundFloor,
            $floorQuality, $rentIncluded);
}

// functions:
function getXml($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Bot');
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 600); // 600 = 10 minutes.
    $r = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    
    if ($info['http_code'] == 200) {
        return $r;
    }
    
    return FALSE;
}
function getFile($url, $dir)
{
    $lfile = fopen($dir.'/'.basename($url), "w");
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Bot');
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); // 60 = 1 minute.
    curl_setopt($ch, CURLOPT_FILE, $lfile);
    $r = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    
    fclose($lfile);
    
    if ($info['http_code'] == 200) {
        return TRUE;
    }
    
    return FALSE;
}
function setVars($uniqueobjectid, $street, $houseNumber, $houseNumberAddtion,
        $postalCode, $city, $SubArea, $houseType, $tenant, $estateOwner, $stats,
        $furnished, $minprice, $hideprice, $NroOfRooms, $NroOfLivingRooms,
        $Projectnaam, $WoningtypeInProject, $Available, $insertDate,
        $description_nl, $description_fr, $description_en,
        $description_de, $description_es, $description_it, $size_m2,
        $numberOfBathrooms, $contractLentgh_months, $minContractLentgh_months,
        $buildYear, $Parking, $bath, $separateShower, $separateToilet, $lift,
        $garden, $gardenLigging, $gardenSizeM2, $roofTerrass,
        $roofTerrassLigging, $roofTerrassSizeM2, $balcony, $BalconyLigging,
        $BalconySizeM2, $swimmingPool, $airConditioning, $firePlace, $garage,
        $cellar, $publicTransportQualityID, $showhouseNumber, $groundFloor,
        $floorQuality, $rentIncluded)
{
    // set vars:
    // TODO
}