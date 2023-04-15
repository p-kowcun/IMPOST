<?php
$black_list = array();
$collection = array();

function check_blacklist($city){
global $black_list;
for ($i = 0; $i<count($black_list); $i++)
{
    if ($city == $black_list[$i])
    {
        return 1;
        }
}

return 0;
}

function rand_with_no_rep($from,$to,$reset = 0){
global $collection;
if ($reset)
{
$collection = array();
return 1;
}
else
{
do{
$r = rand($from,$to);
} while (in_array($r, $collection));
array_push($collection, $r);
}

return $r;
}



function navigate($start, $finish){


$cities = array(
'Szczecin'=> array('Koszalin','Piła', 'Gorzów Wielkopolski'),
'Koszalin'=> array('Szczecin','Słupsk','Piła'),
'Słupsk'=> array('Koszalin','Gdańsk'),
'Gdańsk'=> array('Słupsk','Elbląg','Bydgoszcz'),
'Elbląg'=> array('Gdańsk','Olsztyn','Toruń'),
'Olsztyn'=> array('Elbląg','Suwałki','Ciechanów', 'Ostrołęka'),
'Suwałki'=> array('Olsztyn','Łomża','Białystok'),
'Gorzów Wielkopolski'=> array('Szczecin','Piła','Zielona Góra'),
'Piła'=> array('Gorzów Wielkopolski','Szczecin','Koszalin', 'Bydgoszcz','Poznań'),
'Bydgoszcz'=> array('Piła','Toruń','Poznań','Konin','Gdańsk'),
'Toruń'=> array('Bydgoszcz','Włocławek','Elbląg'),
'Ciechanów'=> array('Olsztyn','Ostrołęka','Płock','Warszawa'),
'Ostrołęka'=> array('Ciechanów','Olsztyn','Łomża','Warszawa'),
'Łomża'=> array('Ostrołęka','Suwałki','Białystok'),
'Białystok'=> array('Suwałki','Łomża','Biała Podlaska'),
'Zielona Góra'=> array('Gorzów Wielkopolski','Leszno','Legnica'),
'Poznań'=> array('Piła','Konin','Bydgoszcz','Leszno'),
'Konin'=> array('Poznań','Włocławek','Kalisz','Bydgoszcz'),
'Włocławek'=> array('Toruń','Konin','Płock'),
'Płock'=> array('Włocławek','Łódź','Skierniewice','Warszawa', 'Ciechanów'),
'Warszawa'=> array('Płock','Ciechanów','Skierniewice', 'Ostrołęka', 'Siedlce', 'Radom'),
'Siedlce'=> array('Warszawa','Biała Podlaska','Radom','Lublin'),
'Biała Podlaska'=> array('Siedlce','Białystok','Lublin','Chełm'),
'Jelenia Góra'=> array('Legnica','Wałbrzych'),
'Legnica'=> array('Zielona Góra','Jelenia Góra','Wrocław','Wałbrzych','Leszno'),
'Wrocław'=> array('Opole','Legnica','Wałbrzych','Kalisz','Leszno'),
'Kalisz'=> array('Leszno','Konin','Sieradź','Wrocław'),
'Sieradź'=> array('Kalisz','Łódź','Piotrków Trybunalski','Częstochowa'),
'Piotrków Trybunalski'=> array('Sieradź','Łódź','Radom','Kielce','Częstochowa'),
'Radom'=> array('Skierniewice','Warszawa','Siedlce','Lublin','Tarnobrzeg','Kielce', 'Piotrków Trybunalski'),
'Lublin'=> array('Siedlce','Biała Podlaska','Chełm','Tarnobrzeg','Radom'),
'Chełm'=> array('Lublin','Biała Podlaska','Zamość'),
'Wałbrzych'=> array('Jelenia Góra','Legnica','Wrocław'),
'Opole'=> array('Wrocław','Częstochowa','Katowice'),
'Częstochowa'=> array('Sieradź','Piotrków Trybunalski','Opole','Kielce','Katowice'),
'Kielce'=> array('Piotrków Trybunalski','Radom','Tarnobrzeg','Tarnów','Kraków','Częstochowa'),
'Tarnobrzeg'=> array('Radom','Lublin','Zamość','Rzeszów','Tarnów','Kielce'),
'Zamość'=> array('Chełm','Tarnobrzeg','Przemyśl'),
'Katowice'=> array('Opole','Częstochowa','Kraków','Bielsko-Biała'),
'Kraków'=> array('Katowice','Kielce','Tarnów','Nowy Sącz', 'Bielsko-Biała'),
'Tarnów'=> array('Kraków','Kielce','Tarnobrzeg','Rzeszów','Krosno','Nowy Sącz'),
'Rzeszów'=> array('Tarnobrzeg','Tarnów','Przemyśl','Krosno'),
'Przemyśl'=> array('Zamość','Rzeszów','Krosno'),
'Bielsko-Biała'=> array('Katowice','Kraków','Nowy Sącz'),
'Nowy Sącz'=> array('Bielsko-Biała','Kraków','Tarnów','Krosno'),
'Krosno'=> array('Nowy Sącz','Tarnów','Rzeszów','Przemyśl'),
'Leszno'=> array('Poznań','Zielona Góra','Legnica','Wrocław','Kalisz'),
'Łódź'=> array('Skierniewice','Sieradź','Piotrków Trybunalski','Płock'),
'Skierniewice'=> array('Płock','Warszawa','Radom','Łódź'),
);

$queue = array($start);
$min = 49;

for($p = 0; $p < 10000; $p++)
{
$black_list = array();

array_push($black_list,$start);
$queue = array($start);

while($queue[count($queue)-1] != $finish)
{

    rand_with_no_rep(0,0,1);
    for($i = 0; $i<count($cities[$queue[count($queue) - 1]]); $i++)
    {

    $city = $cities[$queue[count($queue) - 1]][rand_with_no_rep(0,count($cities[$queue[count($queue) - 1]])-1)];
    if (check_blacklist($city) == 0)
    {
    break;
    }

    }
    if (check_blacklist($city) == 1)
        {
        array_push($black_list,array_pop($queue));
        continue;
        }
    array_push($queue, $city);
    array_push($black_list, $queue[count($queue) - 1]);

}

if(count($queue) < $min){
    $min = count($queue);
    $result = $queue;
    }
}

return $result;
}
?>
