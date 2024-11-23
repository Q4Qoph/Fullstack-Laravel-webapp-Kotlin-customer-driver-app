<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\County;
use App\Models\SubCounty;

class CountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
public function run()
{
    $counties = [
        'Mombasa' => ['Changamwe', 'Jomvu', 'Kisauni', 'Likoni', 'Mvita', 'Nyali'],
        'Kwale' => ['Kinango', 'Lungalunga', 'Matuga', 'Msambweni'],
        'Kilifi' => ['Ganze', 'Kaloleni', 'Kilifi North', 'Kilifi South', 'Magarini', 'Malindi', 'Rabai'],
        'Tana River' => ['Bura', 'Galole', 'Garsen'],
        'Lamu' => ['Lamu East', 'Lamu West'],
        'Taita Taveta' => ['Mwatate', 'Taveta', 'Voi', 'Wundanyi'],
        'Garissa' => ['Balambala', 'Dadaab', 'Fafi', 'Garissa Township', 'Hulugho', 'Ijara', 'Lagdera'],
        'Wajir' => ['Buna', 'Eldas', 'Habaswein', 'Tarbaj', 'Wajir East', 'Wajir North', 'Wajir South', 'Wajir West'],
        'Mandera' => ['Banissa', 'Kutulo', 'Lafey', 'Mandera East', 'Mandera North', 'Mandera South', 'Mandera West'],
        'Marsabit' => ['Laisamis', 'Moyale', 'North Horr', 'Saku'],
        'Isiolo' => ['Isiolo', 'Merti', 'Garbatulla'],
        'Meru' => ['Buuri', 'Igembe Central', 'Igembe North', 'Igembe South', 'Imenti Central', 'Imenti North', 'Imenti South', 'Tigania East', 'Tigania West'],
        'Tharaka Nithi' => ['Chuka/Igambang’ombe', 'Maara', 'Tharaka'],
        'Embu' => ['Manyatta', 'Mbeere North', 'Mbeere South', 'Runyenjes'],
        'Kitui' => ['Kitui Central', 'Kitui East', 'Kitui Rural', 'Kitui South', 'Kitui West', 'Mwingi Central', 'Mwingi North', 'Mwingi West'],
        'Machakos' => ['Kangundo', 'Kathiani', 'Machakos Town', 'Masinga', 'Matungulu', 'Mavoko', 'Mwala', 'Yatta'],
        'Makueni' => ['Kaiti', 'Kilome', 'Makueni', 'Mbooni', 'Kibwezi East', 'Kibwezi West'],
        'Nyandarua' => ['Kinangop', 'Kipipiri', 'Ndaragwa', 'Ol Jorok', 'Ol Kalou'],
        'Nyeri' => ['Kieni East', 'Kieni West', 'Mathira East', 'Mathira West', 'Mukureini', 'Nyeri Town', 'Othaya', 'Tetu'],
        'Kirinyaga' => ['Kirinyaga Central', 'Kirinyaga East', 'Kirinyaga West', 'Mwea East', 'Mwea West'],
        'Murang’a' => ['Gatanga', 'Kandara', 'Kangema', 'Kigumo', 'Kiharu', 'Mathioya', 'Maragwa'],
        'Kiambu' => ['Gatundu North', 'Gatundu South', 'Githunguri', 'Juja', 'Kabete', 'Kiambaa', 'Kiambu Town', 'Kikuyu', 'Limuru', 'Lari', 'Ruiru', 'Thika Town'],
        'Turkana' => ['Loima', 'Turkana Central', 'Turkana East', 'Turkana North', 'Turkana South', 'Turkana West'],
        'West Pokot' => ['Kapenguria', 'Pokot Central', 'Pokot South', 'West Pokot'],
        'Samburu' => ['Samburu Central', 'Samburu East', 'Samburu North'],
        'Trans Nzoia' => ['Cherangany', 'Endebess', 'Kwanza', 'Kiminini', 'Saboti'],
        'Uasin Gishu' => ['Ainabkoi', 'Kapseret', 'Kesses', 'Moiben', 'Soy', 'Turbo'],
        'Elgeyo Marakwet' => ['Keiyo North', 'Keiyo South', 'Marakwet East', 'Marakwet West'],
        'Nandi' => ['Aldai', 'Chesumei', 'Emgwen', 'Mosop', 'Nandi Hills', 'Tinderet'],
        'Baringo' => ['Baringo Central', 'Baringo North', 'Baringo South', 'Eldama Ravine', 'Mogotio', 'Tiaty'],
        'Laikipia' => ['Laikipia East', 'Laikipia North', 'Laikipia West'],
        'Nakuru' => ['Bahati', 'Gilgil', 'Kuresoi North', 'Kuresoi South', 'Molo', 'Nakuru Town East', 'Nakuru Town West', 'Naivasha', 'Njoro', 'Rongai', 'Subukia'],
        'Narok' => ['Narok East', 'Narok North', 'Narok South', 'Narok West', 'Kilgoris', 'Emurua Dikirr'],
        'Kajiado' => ['Kajiado Central', 'Kajiado East', 'Kajiado North', 'Kajiado South', 'Kajiado West'],
        'Kericho' => ['Ainamoi', 'Belgut', 'Bureti', 'Kipkelion East', 'Kipkelion West', 'Soin/Sigowet'],
        'Bomet' => ['Bomet Central', 'Bomet East', 'Chepalungu', 'Konoin', 'Sotik'],
        'Kakamega' => ['Butere', 'Ikolomani', 'Khwisero', 'Lugari', 'Likuyani', 'Malava', 'Matungu', 'Mumias East', 'Mumias West', 'Navakholo', 'Shinyalu'],
        'Vihiga' => ['Emuhaya', 'Hamisi', 'Luanda', 'Sabatia', 'Vihiga'],
        'Bungoma' => ['Bumula', 'Kabuchai', 'Kanduyi', 'Kimilili', 'Mt. Elgon', 'Sirisia', 'Tongaren', 'Webuye East', 'Webuye West'],
        'Busia' => ['Bunyala', 'Butula', 'Funyula', 'Nambale', 'Samia', 'Teso North', 'Teso South'],
        'Siaya' => ['Alego Usonga', 'Bondo', 'Gem', 'Rarieda', 'Ugenya', 'Ugunja'],
        'Kisumu' => ['Kisumu Central', 'Kisumu East', 'Kisumu West', 'Muhoroni', 'Nyakach', 'Nyando', 'Seme'],
        'Homa Bay' => ['Homa Bay Town', 'Kabondo Kasipul', 'Karachuonyo', 'Kasipul', 'Mbita', 'Ndhiwa', 'Rangwe', 'Suba'],
        'Migori' => ['Awendo', 'Kuria East', 'Kuria West', 'Nyatike', 'Rongo', 'Suna East', 'Suna West', 'Uriri'],
        'Kisii' => ['Bobasi', 'Bonchari', 'Kitutu Chache North', 'Kitutu Chache South', 'Nyaribari Chache', 'Nyaribari Masaba', 'South Mugirango'],
        'Nyamira' => ['Borabu', 'Manga', 'Masaba North', 'Nyamira North', 'Nyamira South'],
        'Nairobi' => ['Dagoretti North', 'Dagoretti South', 'Embakasi Central', 'Embakasi East', 'Embakasi North', 'Embakasi South', 'Embakasi West', 'Kamukunji', 'Kasarani', 'Kibra', 'Langata', 'Makadara', 'Mathare', 'Roysambu', 'Ruaraka', 'Starehe', 'Westlands'],
    ];

    foreach ($counties as $county => $subCounties) {
        $countyModel = County::create(['name' => $county]);

        foreach ($subCounties as $subCounty) {
            SubCounty::create(['name' => $subCounty, 'county_id' => $countyModel->id]);
        }
    }
}
}
