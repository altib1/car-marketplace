<?php

namespace App\DataFixtures;

use App\Entity\CarBrand;
use App\Entity\CarModel;
use App\Entity\MotorizationType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Country;
use App\Entity\Region;
use App\Entity\ImportCountry;
use App\Entity\Department;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $brands = [
            'Toyota' => [
                'Corolla' => ['1.8L Petrol', '1.8L Hybrid', '2.0L Hybrid', 'GR 1.6L Turbo'],
                'Camry' => ['2.5L Petrol', '3.5L V6', '2.5L Hybrid'],
                'RAV4' => ['2.0L Petrol', '2.5L Hybrid', '2.5L PHEV (Prime)'],
                'Prius' => ['1.8L Hybrid', '2.0L Hybrid', '2.0L PHEV (Prime)'],
                'Highlander' => ['3.5L V6', '2.5L Hybrid', '2.4L Turbo Hybrid'],
                'Tacoma' => ['3.5L V6', '2.4L Turbo', '2.4L Turbo Hybrid'],
                'Supra' => ['3.0L Turbo', '2.0L Turbo'],
                'Yaris' => ['1.5L Petrol', '1.5L Hybrid', 'GR 1.6L Turbo'],
                'Land Cruiser' => ['4.0L V6', '3.5L Twin-Turbo Hybrid', '2.8L Diesel'],
                '4Runner' => ['4.0L V6', '2.4L Turbo Hybrid'],
                'Sienna' => ['2.5L Hybrid'],
                'C-HR' => ['1.8L Hybrid', '2.0L Hybrid'],
                'Mirai' => ['Hydrogen Fuel Cell'],
                'Tundra' => ['i-FORCE 3.5L Twin-Turbo', 'i-FORCE MAX Hybrid'],
                'Sequoia' => ['i-FORCE 3.5L Twin-Turbo', 'i-FORCE MAX Hybrid'],
                'Hilux' => ['2.4L Diesel', '2.8L Diesel', '4.0L V6'],
                'GR86' => ['2.4L Boxer'],
                'bZ4X' => ['Electric'],
                'Venza' => ['2.5L Hybrid'],
                'Avalon' => ['3.5L V6', '2.5L Hybrid'],
                'Corolla Cross' => ['2.0L Petrol', '2.0L Hybrid'],
                'Proace' => ['Electric'],
                'Hiace' => ['2.8L Diesel', '3.5L V6'],
                'Century' => ['5.0L V8 Hybrid'],
                'Crown' => ['2.5L Hybrid', '2.4L Turbo Hybrid'],
                'Innova' => ['2.0L Petrol', '2.7L Petrol', '2.4L Diesel'],
                'Fortuner' => ['2.7L Petrol', '2.8L Diesel'],
                'GR Yaris' => ['1.6L Turbo'],
                'Urban Cruiser' => ['1.5L Petrol', '1.5L Hybrid']
            ],
            'Ford' => [
                'Mustang' => ['5.0L V8 Petrol', '2.3L EcoBoost Turbo','5.2L Supercharged V8 (Shelby GT500)','Electric AWD (Mach-E GT)'],
                'F-150' => ['3.5L EcoBoost V6', '5.0L Coyote V8', '3.5L PowerBoost Hybrid','3.0L PowerStroke Diesel','Electric (Lightning)'],
                'F-250 Super Duty' => ['7.3L Godzilla V8', '6.7L PowerStroke Diesel'],
                'F-150 Raptor' => ['3.5L High-Output EcoBoost', '5.2L Supercharged V8 (Raptor R)'],
                'Explorer' => ['2.3L EcoBoost', '3.0L EcoBoost V6', '3.3L Hybrid'],
                'Escape' => ['1.5L EcoBoost', '2.0L EcoBoost', '2.5L Hybrid', '2.5L PHEV'],
                'Edge' => ['2.0L EcoBoost', '2.7L EcoBoost V6'],
                'Bronco' => ['2.3L EcoBoost', '2.7L EcoBoost V6', '3.0L EcoBoost (Raptor)'],
                'Ranger' => ['2.3L EcoBoost', '3.0L V6 (Global)', '2.0L Bi-Turbo Diesel','3.0L EcoBoost (Raptor)'],
                'Maverick' => ['2.0L EcoBoost', '2.5L Hybrid'],
                'Expedition' => ['3.5L EcoBoost', '3.5L PowerBoost Hybrid'],
                'Transit' => ['2.0L EcoBoost', '3.5L EcoBoost', '2.0L Diesel', 'Electric'],
                'Focus' => ['1.0L EcoBoost', '1.5L EcoBoost', '2.3L EcoBoost (ST)', '2.3L EcoBoost (RS)'],
                'Fiesta' => ['1.0L EcoBoost', '1.5L Diesel'],
                'Everest' => ['2.0L Bi-Turbo Diesel', '3.0L V6 Petrol'],
                'Figo' => ['1.5L Petrol', '1.5L Diesel'],
                'Puma' => ['1.0L EcoBoost', '1.5L Diesel'],
                'Mustang Mach-E' => ['Standard Range RWD', 'Extended Range AWD','GT Performance'],
                'E-Transit' => ['Electric'],
                'Territory' => ['1.5L EcoBoost', 'Hybrid'],
                'Endeavour' => ['2.0L BiT Diesel', '3.2L Diesel'],
                'GT' => ['3.5L EcoBoost V6'],
                'Thunderbird' => ['5.0L V8 (Heritage)'],
                'Crown Victoria' => ['4.6L V8 (Fleet)']
            ],
            'BMW' => [
                '3 Series' => ['318i', '320i', '330i', '340i', '318d', '320d', '330d', 'M340i', '330e PHEV', 'M3', 'M3 Competition', 'M3 CS'],
                '5 Series' => ['520i', '530i', '540i', '550i','520d', '530d', '540d', 'M550i','530e PHEV', '545e PHEV', 'M5', 'M5 Competition', 'M5 CS'],
                '7 Series' => ['740i', '750i', '760i', '730d', '740d', '750d','745e PHEV', 'i7 Electric', 'ALPINA B7', 'M760e PHEV', 'Protection VR6'],
                'X3' => ['sDrive20i', 'xDrive20i', 'xDrive30i', 'xDrive20d', 'xDrive30d', 'M40i','xDrive30e PHEV', 'X3 M', 'X3 M Competition'],
                'X5' => ['xDrive40i', 'xDrive45e PHEV', 'xDrive30d', 'xDrive40d', 'M50i','X5 M', 'X5 M Competition', 'xDrive50e PHEV'],
                'X7' => ['xDrive40i', 'xDrive50i', 'M60i','xDrive30d', 'xDrive40d', 'ALPINA XB7', 'X7 M60i'],
                'Z4' => ['sDrive20i', 'sDrive30i', 'M40i', 'M Performance Edition'],
                'i Series' => ['i4 eDrive40', 'i4 M50','iX xDrive40', 'iX xDrive50', 'iX M60','iX3', 'i7 xDrive60', 'i8 Coupe (Discontinued)'],
                '4 Series' => ['420i', '430i', '440i', 'M440i', 'M4', 'M4 Competition','420d', '430d', 'Gran Coupe'],
                '8 Series' => ['840i', '850i', 'M850i','830d', '840d', 'M8', 'M8 Competition', 'Gran Coupe'],
                'X1' => ['sDrive18i', 'xDrive25e PHEV', 'M35i'],
                'X2' => ['sDrive20i', 'xDrive25e PHEV', 'M35i'],
                'X4' => ['xDrive30i', 'M40i', 'X4 M'],
                'X6' => ['xDrive40i', 'M50i', 'X6 M'],
                'M2' => ['M2', 'M2 Competition'],
                'XM' => ['XM 50e PHEV', 'XM Label Red'],
                '2 Series Gran Coupe' => ['218i', '220d', 'M235i'],
                '4 Series Gran Coupe' => ['420i', '430i', 'M440i'],
                '8 Series Gran Coupe' => ['840i', 'M850i', 'M8'],
                'iX1' => ['Electric'],
                'iX2' => ['Electric'],
                'i5' => ['i5 eDrive40', 'i5 M60'],
                'Z8' => ['Heritage'],
                'M1' => ['Heritage'],
                '850CSI' => ['Heritage'],
                '2002 Turbo' => ['Heritage'],
                '3.0 CSL' => ['2023 Edition']
            ],
            'Mercedes-Benz' => [
                'A-Class' => ['A 160', 'A 180', 'A 200', 'A 220d', 'A 250', 'A 35 AMG', 'A 45 S AMG', 'A 250e PHEV', 'A 200 4MATIC'],
                'C-Class' => ['C 180', 'C 200', 'C 220d', 'C 300', 'C 300e PHEV', 'C 400d', 'C 43 AMG', 'C 63 S AMG', 'C 220d 4MATIC', 'C 300 4MATIC'],
                'E-Class' => ['E 200', 'E 220d', 'E 300', 'E 400', 'E 450 4MATIC', 'E 300e PHEV', 'E 53 AMG', 'E 63 S AMG', 'E 400d', 'E 580 4MATIC'],
                'S-Class' => ['S 450', 'S 500', 'S 560', 'S 580', 'S 580e PHEV', 'S 63 AMG', 'S 680 Maybach', 'S 350d', 'S 400d', 'S 650 Maybach (Discontinued)'],
                'G-Class' => ['G 350', 'G 400d', 'G 500', 'G 550', 'G 63 AMG', 'G 65 AMG (Discontinued)', 'G 300 Professional', 'G 400d 4MATIC'],
                'GLA' => ['GLA 180', 'GLA 200', 'GLA 220d', 'GLA 250', 'GLA 35 AMG', 'GLA 45 S AMG', 'GLA 250e PHEV'],
                'GLB' => ['GLB 180', 'GLB 200', 'GLB 220d', 'GLB 250', 'GLB 35 AMG', 'GLB 250e PHEV'],
                'GLC' => ['GLC 200', 'GLC 220d', 'GLC 300', 'GLC 300e PHEV', 'GLC 43 AMG', 'GLC 63 S AMG', 'GLC 400d', 'GLC 450 4MATIC'],
                'GLE' => ['GLE 350d', 'GLE 400d', 'GLE 450', 'GLE 53 AMG', 'GLE 63 S AMG', 'GLE 580', 'GLE 300d', 'GLE 350e PHEV', 'GLE 450e PHEV'],
                'GLS' => ['GLS 400d', 'GLS 450', 'GLS 580', 'GLS 600 Maybach', 'GLS 63 AMG', 'GLS 350d', 'GLS 500e PHEV'],
                'CLA' => ['CLA 180', 'CLA 200', 'CLA 220d', 'CLA 250', 'CLA 35 AMG', 'CLA 45 S AMG', 'CLA 250e PHEV', 'CLA 200 Shooting Brake'],
                'CLS' => ['CLS 220d', 'CLS 300', 'CLS 450', 'CLS 53 AMG', 'CLS 400d', 'CLS 63 S AMG (Discontinued)'],
                'AMG GT' => ['GT 43', 'GT 53', 'GT 63 S', 'GT 63 S E Performance', 'GT Black Series', 'GT Roadster', 'GT R Pro'],
                'EQS' => ['EQS 450+', 'EQS 580 4MATIC', 'AMG EQS 53', 'EQS 680 Maybach'],
                'EQE' => ['EQE 350+', 'EQE 500 4MATIC', 'AMG EQE 53', 'EQE SUV', 'EQE 350 SUV'],
                'EQC' => ['EQC 400 4MATIC', 'EQC 350', 'EQC Edition 1886 (Discontinued)'],
                'SL' => ['SL 55 AMG', 'SL 63 AMG', 'SL 43 AMG', 'SL 73 AMG (Discontinued)'],
                'Maybach' => ['Maybach S 580', 'Maybach S 680', 'Maybach GLS 600', 'Maybach EQS 680']
            ],
            'Honda' => [
                'Civic' => ['2.0L i-VTEC Petrol', '1.5L Turbo Petrol', '1.5L e:HEV Hybrid','2.0L e:HEV Hybrid','Type R 2.0L Turbo','Hatchback 1.0L Turbo (Global)'],
                'Accord' => ['2.0L Turbo Petrol', '2.0L e:HEV Hybrid', '2.4L Petrol (Discontinued)','Sport 2.0L Turbo','Plug-in Hybrid (Discontinued)'],
                'CR-V' => ['1.5L Turbo Petrol', '2.0L e:HEV Hybrid', '2.4L i-VTEC (Discontinued)','1.6L i-DTEC Diesel (Global)','Black Edition 1.5L Turbo'],
                'HR-V' => ['1.8L i-VTEC Petrol', '1.5L e:HEV Hybrid', '1.5L Turbo Petrol (Global)','Sport 1.8L Petrol'],
                'Pilot' => ['3.5L V6 Petrol', '3.5L i-VTEC V6', 'Hybrid 3.0L V6 (Japan)','TrailSport 3.5L V6'],
                'Ridgeline' => ['3.5L V6 Petrol', '3.5L i-VTEC V6', 'Black Edition 3.5L V6'],
                'Insight' => ['1.5L e:HEV Hybrid', '2.0L e:HEV Hybrid', '1.3L Hybrid (Discontinued)'],
                'Fit' => ['1.5L i-VTEC Petrol', '1.5L e:HEV Hybrid', '1.3L Petrol (Global)','Jazz Sport 1.5L (Europe)'],
                'Odyssey' => ['3.5L V6 Petrol', '2.4L i-VTEC (Global)', 'Absolute 3.5L V6 (Japan)', 'Elite 3.5L V6'],
                'Passport' => ['3.5L V6 Petrol', '3.5L i-VTEC V6', 'TrailSport 3.5L V6'],
                'BR-V' => ['1.5L i-VTEC Petrol (Global)', '1.5L i-DTEC Diesel (India)'],
                'City' => ['1.5L i-VTEC Petrol (Asia)', '1.5L e:HEV Hybrid', '1.0L Turbo (Brazil)'],
                'N-Box' => ['0.66L Turbo (Japan)', '0.66L e:HEV Hybrid', 'Custom 0.66L Turbo'],
                'e:NY1' => ['Electric'],
                'Prologue' => ['Electric AWD'],
                'Clarity' => ['Fuel Cell (Discontinued)', 'Plug-in Hybrid (Discontinued)'],
                'Legend' => ['3.5L Hybrid (Japan)', '3.7L V6 (Heritage)'],
                'NSX' => ['3.5L Twin-Turbo Hybrid (Discontinued)']
            ],
            'Audi' => [
                'A3' => ['30 TFSI', '35 TFSI', '40 TFSI', 'S3', 'RS3', '30 TDI', '35 TDI', '40 TFSI e PHEV', 'Sportback 45 TFSI', 'Sedan 35 TFSI'],
                'A4' => ['35 TFSI', '40 TFSI', '45 TFSI', 'S4', 'RS4', '35 TDI', '40 TDI', 'A4 Avant', 'A4 Allroad', '50 TFSI e PHEV', 'S4 Avant'],
                'A6' => ['40 TFSI', '45 TFSI', '50 TFSI', 'S6', 'RS6', '40 TDI', '50 TDI', 'A6 Avant', 'A6 Allroad', '55 TFSI e PHEV', 'S6 TDI'],
                'A8' => ['A8 L 55 TFSI', 'A8 L 60 TFSI', 'S8', 'A8 L Horch', 'A8 L 50 TDI', 'A8 L 60 TDI', 'S8 e-tron (Discontinued)'],
                'Q3' => ['Q3 35 TFSI', 'Q3 40 TFSI', 'Q3 45 TFSI', 'RS Q3', 'Q3 35 TDI', 'Q3 Sportback', 'Q3 45 TFSI e PHEV'],
                'Q5' => ['Q5 40 TFSI', 'Q5 45 TFSI', 'Q5 55 TFSI', 'SQ5', 'Q5 40 TDI', 'Q5 50 TDI', 'Q5 Sportback', 'Q5 55 TFSI e PHEV'],
                'Q7' => ['Q7 45 TFSI', 'Q7 55 TFSI', 'Q7 60 TFSI', 'SQ7', 'Q7 45 TDI', 'Q7 50 TDI', 'Q7 60 TDI', 'Q7 55 TFSI e PHEV'],
                'Q8' => ['Q8 55 TFSI', 'Q8 60 TFSI', 'SQ8', 'RS Q8', 'Q8 50 TDI', 'Q8 e-tron', 'Q8 Sportback'],
                'TT' => ['TT Coupe 40 TFSI', 'TT Roadster 45 TFSI', 'TTS', 'TT RS', 'TT Ultra Sport (Discontinued)'],
                'R8' => ['R8 Coupe V10', 'R8 Spyder V10', 'R8 GT', 'R8 e-tron (Discontinued)', 'R8 Performance Quattro'],
                'e-tron GT' => ['e-tron GT quattro', 'RS e-tron GT', 'e-tron GT Sportback'],
                'Q4 e-tron' => ['Q4 35 e-tron', 'Q4 40 e-tron', 'Q4 45 e-tron', 'Q4 Sportback'],
                'A5' => ['A5 35 TFSI', 'A5 40 TFSI', 'A5 45 TFSI', 'S5', 'RS5', 'A5 Sportback', 'A5 Cabriolet'],
                'A7' => ['A7 40 TFSI', 'A7 45 TFSI', 'A7 55 TFSI', 'S7', 'RS7', 'A7 Sportback'],
                'Q2' => ['Q2 30 TFSI', 'Q2 35 TFSI', 'Q2 35 TDI', 'SQ2', 'Q2 e-tron (China)'],
                'e-tron' => ['e-tron 50', 'e-tron 55', 'e-tron S', 'e-tron Sportback', 'e-tron GT Concept'],
                'RS Models' => ['RS Q8', 'RS6 Avant', 'RS7 Sportback', 'RS e-tron GT', 'RS3 Sportback']
            ],
            'Chevrolet' => [
                'Silverado' => ['4.3L V6', '5.3L V8', '6.2L V8', '3.0L Duramax Turbo-Diesel', '2.7L Turbo', 'ZR2 Off-Road', 'High Country', 'Hybrid 6.0L V8 (Discontinued)', 'Electric RST'],
                'Malibu' => ['1.5L Turbo', '2.0L Turbo', 'Hybrid 1.8L', '2.5L (Discontinued)', 'Premier 2.0T', 'Sport Edition'],
                'Equinox' => ['1.5L Turbo', '2.0L Turbo', 'RS 2.0T', '1.6L Diesel (Global)', 'Premier 2.0T AWD', 'Hybrid (China)'],
                'Tahoe' => ['5.3L V8', '6.2L V8', '3.0L Duramax Diesel', 'Hybrid 6.0L V8', 'RST Performance', '6.0L V8 (Discontinued)'],
                'Traverse' => ['3.6L V6', '2.0L Turbo (Global)', 'RS 3.6L', 'Premier AWD', 'High Country 3.6L'],
                'Camaro' => ['2.0L Turbo', '3.6L V6', '6.2L V8', 'ZL1 6.2L Supercharged', '1LE Track Pack', 'Z/28 7.0L (Discontinued)', 'eCOPO Electric Concept'],
                'Corvette' => ['6.2L V8', '5.5L V8 (Z06)', 'E-Ray Hybrid AWD', 'ZR1 5.5L Twin-Turbo', '7.0L V8 (C6.R Heritage)', 'Convertible'],
                'Blazer' => ['2.0L Turbo', '3.6L V6', 'RS 3.6L', 'SS 6.2L V8 (Discontinued)', 'EV', 'PHEV (China)'],
                'Trailblazer' => ['1.3L Turbo', '1.2L Turbo (Global)', 'RS 1.3T', 'Activ Off-Road', '1.5L Diesel (India)'],
                'Spark' => ['1.4L Petrol', '1.2L (Global)', 'EV (Discontinued)', 'Activ 1.4L'],
                'Suburban' => ['5.3L V8', '6.2L V8', '3.0L Duramax Diesel', 'Z71 Off-Road', 'High Country 6.2L'],
                'Colorado' => ['2.7L Turbo', '3.6L V6', '2.8L Duramax Diesel', 'ZR2 Bison', 'Z71 Off-Road', 'WT Base'],
                'Bolt' => ['EV', 'EUV', '2LT', 'Premier', 'Redline Edition'],
                'Express' => ['4.3L V6', '5.3L V8', '6.6L V8', '2.8L Diesel', 'Cargo Van', 'Passenger'],
                'Sonic' => ['1.4L Turbo', '1.8L', 'RS 1.4T', '1.3L (Global)', 'Hatchback'],
                'SS' => ['6.2L V8 (Sedan)', '6.0L V8 (Discontinued)', '4.3L V6 (Global)'],
                'Volt' => ['1.5L Hybrid (Discontinued)', 'Premier PHEV'],
                'Cruze' => ['1.4L Turbo', '1.6L Diesel', 'Premier (Discontinued)', 'RS Hatchback'],
                'C/K Series' => ['6.6L V8', '7.4L Big Block', '454 SS (Heritage)', 'Dually']
            ],
            'Nissan' => [
                'Altima' => ['2.5L QR25DE', '2.0L VC-Turbo', '2.5L Hybrid (Discontinued)', 'SR 2.0T', 'Platinum 2.0T AWD', '1.6L Turbo (China)'],
                'Maxima' => ['3.5L VQ35DE V6', 'SR 3.5L', 'Platinum 3.5L', '3.5L Hybrid (Discontinued)', '400R Concept 3.0T (Heritage)'],
                'Rogue' => ['2.5L MR20DD', '1.5L KR15DDT Turbo', 'e-Power Hybrid', 'SV Premium 1.5T', '2.0L Diesel (Global)', 'Rogue Sport 2.0L'],
                'Murano' => ['3.5L VQ35DD V6', 'Platinum 3.5L', 'CrossCabriolet 3.5L (Discontinued)', 'Hybrid 2.5L Supercharged (Japan)'],
                'Pathfinder' => ['3.5L VQ35DD V6', 'Rock Creek 3.5L', '2.0L Turbo (China)', 'Hybrid 2.5L (Discontinued)', '4x4 Platinum 3.5L'],
                'Sentra' => ['2.0L MR20DD', '1.6L Turbo (SR Turbo)', 'SE-R 2.0L', '1.8L (Global)', 'Nismo Concept 1.6T'],
                'Versa' => ['1.6L HR16DE', 'SR 1.6L', '1.8L (Global)', '1.2L Supercharged (Discontinued)', 'Sedan/V-Drive'],
                'Titan' => ['5.6L VK56VD V8', 'XD Diesel 5.0L V8', 'PRO-4X 5.6L', 'Warrior Concept 5.6L', 'Platinum Reserve 5.6L'],
                'Armada' => ['5.6L VK56VD V8', 'Platinum 5.6L', 'Midnight Edition', '2.8L Diesel (Global)', 'Nismo 5.6L Concept'],
                'Juke' => ['1.6L MR16DDT Turbo', 'Nismo RS 1.6T', '1.0L DIG-T (Europe)', 'e-Power Hybrid (Japan)', 'Juke-R 3.8L V6 (Special Edition)'],
                'Leaf' => ['40 kWh Electric', '62 kWh e+', 'Nismo RC Electric Concept', '2.ZERO Special Edition'],
                'Z' => ['3.0L VR30DDTT Twin-Turbo', 'Nismo 3.0T', 'Heritage Edition', '432SC (Discontinued)', '50th Anniversary'],
                'Kicks' => ['1.6L HR16DE', 'e-Power Hybrid', 'SR 1.6L', '1.3L Turbo (Global)', 'Midnight Edition'],
                'Frontier' => ['3.8L V6', '2.8L Turbodiesel (Global)', 'PRO-4X 3.8L', 'Desert Runner', 'Midnight Edition'],
                'GT-R' => ['3.8L VR38DETT Twin-Turbo', 'Nismo 3.8T', 'Track Edition', '50th Anniversary', 'SpecV (Discontinued)'],
                'Navara' => ['2.5L Turbo Diesel (Global)', '2.3L Twin-Turbo', 'PRO-4X Warrior', 'Calibre-X 2.5L', 'Stealth Edition'],
                'Ariya' => ['87 kWh e-4ORCE', '63 kWh FWD', 'Performance 91 kWh', 'Evolve+', 'Premiere Edition'],
                'Cube' => ['1.8L MR18DE (Discontinued)', '1.6L Turbo (Japan)', 'Krom Edition', 'Shakotan Special'],
                'X-Trail' => ['2.5L QR25DE', '1.5L Turbo (Global)', 'e-Power Hybrid', '4x4 Turbo Diesel', 'N-TREK Adventure']
            ],
            'Hyundai' => [
                'Elantra' => ['2.0L MPi Petrol', '1.6L Gamma T-GDi', '2.0L Hybrid', 'N Line 1.6T', 'Elantra N 2.0T', '1.4L Kappa T-GDi (Global)', '1.6L CRDi Diesel (India)'],
                'Sonata' => ['2.5L Smartstream GDi', '2.0L Theta III T-GDi', '2.0L Hybrid', '1.6L T-GDi (China)', 'N Line 2.5T', 'Plug-in Hybrid 2.0L', 'Nexo Fuel Cell (Discontinued)'],
                'Tucson' => ['2.5L Smartstream GDi', '1.6L T-GDi', '2.0L Hybrid', '1.6T PHEV', 'N Line 1.6T', '2.0L CRDi Diesel (Global)', 'Tucson N 2.5T (Concept)'],
                'Santa Fe' => ['2.5L T-GDi', '2.2L CRDi Diesel', '3.5L MPi V6', '1.6T Hybrid', 'Calligraphy 2.5T', '2.0L PHEV', '3.0L V6 (Discontinued)'],
                'Kona' => ['2.0L MPi', '1.6L Gamma T-GDi', 'Electric 64 kWh', 'Electric 39 kWh', 'N Line 1.6T', 'Kona N 2.0T', '1.0L T-GDi (Europe)'],
                'Palisade' => ['3.8L Lambda II V6', '2.2L CRDi Diesel (Global)', 'Calligraphy 3.8L', 'Hybrid 1.6T (Upcoming)', 'HTRAC AWD 3.8L'],
                'Venue' => ['1.6L Gamma II', '1.0L T-GDi (Global)', '1.4L Kappa (India)', 'N Line 1.6L', '1.5L CRDi Diesel (Emerging Markets)'],
                'Ioniq' => ['1.6L GDi Hybrid', '1.6L PHEV', 'Electric 38 kWh', 'Ioniq 5 77.4 kWh', 'Ioniq 6 77.4 kWh', 'Ioniq 7 Concept', 'N e-Shift Performance (Concept)'],
                'Genesis' => ['3.3L Lambda T-GDi V6', '5.0L Tau V8', '2.5L T-GDi Theta III', '3.5L T-GDi V6', 'Electric 87 kWh (GV60)', '5.0L V8 Ultimate (Discontinued)'],
                'Accent' => ['1.6L Gamma II', '1.4L Kappa (Global)', '1.5L CRDi Diesel', 'SR 1.6L', '1.0L T-GDi (Middle East)'],
                'Veloster' => ['2.0L Nu MPi', '1.6L Gamma T-GDi', 'Veloster N 2.0T', 'Turbo R-Spec 1.6T', '2.0L CRDi (Discontinued)'],
                'Creta' => ['1.5L MPi (India)', '1.4L T-GDi (Global)', '1.5L CRDi Diesel', 'SX(O) 1.4T', 'N Line 1.6T (Upcoming)'],
                'Nexo' => ['Hydrogen Fuel Cell', 'Blue Drive Edition', 'Range+ 161 HP', 'FCEV Concept'],
                'Staria' => ['3.5L MPi V6', '2.2L CRDi Diesel', '1.6T Hybrid', 'Cargo Van 2.2D', 'Lounge Premium 3.5L'],
                'Casper' => ['1.0L MPi', '1.0L T-GDi', 'Urban Edition 1.0L', 'Cross 1.0T'],
                'Grandeur' => ['3.3L Lambda II V6', '2.5L T-GDi', 'Hybrid 1.6T', 'Azera 3.0L (Discontinued)', 'Iconic Edition 3.3L'],
                'N Vision 74' => ['Hydrogen Hybrid Concept', '62 kWh Battery', 'Dual Motor AWD', '680 HP Performance']
            ],
            'Volkswagen' => [
                'Golf' => ['1.0L TSI', '1.4L TSI', '1.5L eTSI', '2.0L TDI', 'GTI 2.0L TSI', 'R 2.0L TSI', 'GTE 1.4L PHEV', 'Alltrack 1.8L TSI', 'GTD 2.0L TDI', 'eHybrid 1.4L (Discontinued)'],
                'Golf Plus' => ['1.2L TSI', '1.4L TSI', '1.6L TDI', '2.0L TDI', 'BlueMotion 1.6L TDI', 'Life 1.6L', 'Highline 2.0L TDI'],
                'Golf Sportsvan' => ['1.0L TSI', '1.4L TSI', '1.5L TSI', '1.6L TDI', '2.0L TDI', 'Highline 1.5L TSI', 'Sound 1.4L TSI'],
                'Passat' => ['1.5L TSI', '2.0L TSI', '2.0L TDI', 'GTE 1.4L PHEV', 'Alltrack 2.0L TDI', 'R-Line 2.0L TSI', '3.6L VR6 (Discontinued)'],
                'Passat CC' => ['1.8L TSI', '2.0L TSI', '2.0L TDI', '3.6L VR6', 'R-Line 2.0L TSI', 'Elegance 2.0L TDI'],
                'Tiguan' => ['1.5L TSI', '2.0L TSI', '2.0L TDI', 'eHybrid 1.4L PHEV', 'R 2.0L TSI', 'Allspace 2.0L TDI', 'R-Line 2.0L TSI'],
                'Jetta' => ['1.4L TSI', '1.8L TSI', '2.0L TDI', 'GLI 2.0L TSI', 'Hybrid 1.4L', 'Sport 1.8L Turbo', 'R-Line 2.0L TSI (Mexico)'],
                'Atlas' => ['2.0L TSI', '3.6L VR6', '2.0L TDI (Global)', 'Cross Sport 2.0T', 'R-Line 3.6L', 'SEL Premium 3.6L'],
                'Beetle' => ['1.8L TSI', '2.0L TSI', '1.6L TDI (Discontinued)', 'Final Edition 2.0T', 'Cabriolet 1.4L TSI', 'R-Line 2.0L (Discontinued)'],
                'New Beetle' => ['1.2L TSI', '1.6L MPI', '1.8L Turbo', '1.9L TDI', '2.0L', '2.5L (US)', 'RSi 3.2L VR6 (Limited)'],
                'Polo' => ['1.0L MPI', '1.0L TSI', '1.6L TDI', 'GTI 2.0L TSI', 'R-Line 1.5L TSI', 'Beats Edition 1.0L', '1.4L TSI (Discontinued)'],
                'T-Roc' => ['1.0L TSI', '1.5L TSI', '2.0L TDI', 'R 2.0L TSI', 'Cabriolet 1.5L TSI', 'Style 1.5L eTSI', 'R-Line 2.0L TDI'],
                'Arteon' => ['2.0L TSI', '2.0L TDI', 'R 2.0L TSI', 'Shooting Brake 2.0T', 'eHybrid 1.4L PHEV', '4MOTION 2.0L TSI', 'Elegance 2.0L TDI'],
                'ID.4' => ['Pro 77kWh', 'GTX 77kWh', 'Pro S 82kWh', 'AWD 302 HP', '1st Edition 82kWh', 'Pure 55kWh (Europe)'],
                'ID.3' => ['Pro 58kWh', 'Pro S 77kWh', 'GTX 79kWh', 'Life 45kWh', 'Tour 62kWh', 'Max 82kWh (Upcoming)'],
                'Touareg' => ['3.0L TSI', '3.0L TDI', '4.0L V8 TDI (Global)', 'R 3.0L PHEV', 'E-Hybrid 3.0L', 'R-Line 3.0L TDI', 'W12 (1st Gen)'],
                'Amarok' => ['2.0L BiTDI', '3.0L V6 TDI', 'PanAmericana 3.0L', 'Aventura 3.0L', '2.3L EcoBoost (Global)', 'Extreme 3.0L V6'],
                'Caddy' => ['1.5L TSI', '2.0L TDI', '1.6L TDI', 'Alltrack 2.0L', 'eHybrid 1.4L PHEV', 'Cargo 1.6L TDI', 'Life 1.5L TSI'],
                'Up!' => ['1.0L MPI', '1.0L TGI', 'e-Up! 32kWh', 'GTI 1.0L Turbo', 'Move Up 1.0L', 'Cross Up 1.0L TSI'],
                'ID.Buzz' => ['Pro 82kWh', 'Cargo 77kWh', 'GTX 89kWh (Upcoming)', 'LWB 111kWh', 'Camper Edition 82kWh', '1st Edition 82kWh'],
                'Taigo' => ['1.0L TSI', '1.5L TSI', 'R-Line 1.5L', 'Style 1.0L MPI', '1.6L TDI (Global)', 'eTSI 1.0L Mild Hybrid'],
                'T-Cross' => ['1.0L TSI', '1.5L TSI', '1.6L TDI', 'R-Line 1.5L', 'Style 1.0L', 'eHybrid 1.4L PHEV'],
                'Teramont' => ['2.0L TSI', '2.5L VR6', '3.6L V6 (Global)', 'R-Line 2.0T', 'SEL Premium 2.5L', 'XRT Off-Road 3.6L'],
                'Nivus' => ['1.0L TSI', '1.5L TSI', 'R-Line 1.5L', 'GT 1.4L TSI (Brazil)', '1.6L MSI (Global)', 'Comfortline 1.0L'],
                'California' => ['2.0L TDI', '2.0L TSI', '3.0L V6 TDI', 'Ocean 2.0TDI', 'Beach 2.0TSI', 'eHybrid 1.4L PHEV (Concept)'],
                'Touran' => ['1.2L TSI', '1.4L TSI', '1.5L TSI', '1.6L TDI', '2.0L TDI', 'R-Line 1.5L TSI', 'Highline 2.0L TDI'],
                'Sharan' => ['1.4L TSI', '2.0L TSI', '2.0L TDI', 'SEAT Alhambra 2.0L TDI', 'Highline 2.0L TSI', 'Comfortline 1.4L TSI'],
                'Scirocco' => ['1.4L TSI', '2.0L TSI', '2.0L TDI', 'R 2.0L TSI', 'GTS 2.0L TSI', 'Wolfsburg Edition 1.4L TSI'],
                'Lupo' => ['1.0L', '1.4L', '1.2L TDI', '1.6L GTI', '3L TDI (Discontinued)', '1.7L SDI (Discontinued)'],
                'Fox' => ['1.2L', '1.4L', '1.6L', '1.9L TDI (South America)', 'BlueMotion 1.4L', 'Style 1.4L'],
                'Bora' => ['1.6L', '1.8L Turbo', '2.0L', '2.8L VR6', '1.9L TDI', 'Sportline 2.0L', 'Highline 1.8T'],
                'Phaeton' => ['3.2L V6', '4.2L V8', '6.0L W12', '3.0L V6 TDI', '5.0L V10 TDI', 'Long Wheelbase 6.0L W12'],
                'Eos' => ['1.4L TSI', '2.0L TSI', '2.0L TDI', '3.2L VR6', 'Final Edition 2.0L TSI', 'Sport 2.0L TSI'],
                'ID.5' => ['Pro 77kWh', 'GTX 77kWh', 'Pro Performance 77kWh', 'Max 77kWh', 'Business 77kWh']
            ],
            'Subaru' => [
                'Outback' => ['2.5L Boxer Petrol', '2.4L Turbo Boxer', '2.5L e-Boxer Hybrid (Certain Markets)', 'Wilderness 2.4L Turbo'],
                'Forester' => ['2.5L Boxer Petrol', '2.0L e-Boxer Hybrid (Certain Markets)', 'Wilderness 2.5L'],
                'Crosstrek' => ['2.0L Boxer Petrol', '2.5L Boxer Petrol', '2.0L e-Boxer Hybrid (Certain Markets)', 'Wilderness 2.5L'],
                'Impreza' => ['2.0L Boxer Petrol', '1.6L Boxer Petrol (Certain Markets)'],
                'Ascent' => ['2.4L Turbo Boxer', 'Onyx Edition 2.4L Turbo', 'Touring 2.4L Turbo'],
                'BRZ' => ['2.4L Boxer Petrol'],
                'Legacy' => ['2.5L Boxer Petrol', '2.4L Turbo Boxer'],
                'WRX' => ['2.4L Turbo Boxer'],
                'Solterra' => ['Electric AWD'],
                'Levorg' => ['1.8L Turbo Boxer'],
                'Baja' => ['2.5L Boxer Petrol (Discontinued)', 'Turbo 2.5L (Discontinued)'],
                'Tribeca' => ['3.6L Boxer (Discontinued)', '3.0L Boxer (Discontinued)'],
                'Exiga' => ['2.0L Boxer (Japan)', '2.5L Turbo Boxer (Japan)'],
                'SVX' => ['3.3L Boxer (Heritage)']
            ],
            'Porsche' => [
                '911' => ['Carrera', 'Carrera S', 'Carrera 4', 'Carrera 4S', 'Turbo', 'Turbo S', 'Targa 4', 'Targa 4S', 'GT3', 'GT3 RS', 'GT2 RS', 'Sport Classic', 'Dakar'],
                'Cayenne' => ['Cayenne', 'Cayenne S', 'Cayenne E-Hybrid', 'Cayenne Turbo', 'Cayenne Turbo GT', 'Cayenne GTS', 'Cayenne Coupe', 'Cayenne Coupe Turbo'],
                'Macan' => ['Macan', 'Macan T', 'Macan S', 'Macan GTS', 'Macan Turbo', 'Macan EV (Upcoming)'],
                'Panamera' => ['Panamera', 'Panamera 4', 'Panamera 4S', 'Panamera Turbo', 'Panamera Turbo S', 'Panamera GTS', 'Panamera E-Hybrid', 'Panamera Turbo S E-Hybrid'],
                'Taycan' => ['Taycan', 'Taycan 4S', 'Taycan GTS', 'Taycan Turbo', 'Taycan Turbo S', 'Taycan Cross Turismo', 'Taycan Sport Turismo'],
                '718' => ['718 Cayman', '718 Cayman S', '718 Cayman GTS 4.0', '718 Cayman GT4', '718 Spyder', '718 Boxster', '718 Boxster S', '718 Boxster GTS 4.0', '718 Boxster 25 Years']
            ],
            'Mazda' => [
                'Mazda2' => ['1.5L Petrol', '1.5L Diesel (Certain Markets)'],
                'Mazda3' => ['2.0L Petrol', '2.5L Petrol', '2.5L Turbo Petrol (Certain Markets)', '2.2L Diesel (Discontinued)', 'e-Skyactiv X 2.0L (Mild Hybrid)'],
                'Mazda6' => ['2.5L Petrol', '2.5L Turbo Petrol', '2.2L Diesel'],
                'CX-3' => ['2.0L Petrol', '1.5L Diesel (Certain Markets)'],
                'CX-30' => ['2.0L Petrol', '2.5L Petrol', 'e-Skyactiv X 2.0L (Mild Hybrid)'],
                'CX-5' => ['2.0L Petrol', '2.5L Petrol', '2.5L Turbo Petrol', '2.2L Diesel'],
                'CX-50' => ['2.5L Petrol', '2.5L Turbo Petrol'],
                'CX-60' => ['2.5L Petrol', '2.5L PHEV (Plug-in Hybrid)', '3.3L Turbo Diesel'],
                'CX-70' => ['3.3L Turbo Petrol (Upcoming)', 'PHEV (Upcoming)'],
                'CX-80' => ['3.3L Turbo Diesel', 'PHEV (Upcoming)'],
                'CX-90' => ['3.3L Turbo Petrol', '3.3L Turbo Diesel', 'PHEV'],
                'MX-5 Miata' => ['1.5L Petrol (Certain Markets)', '2.0L Petrol'],
                'MX-30' => ['Electric', 'Range Extender (Rotary Hybrid)'],
                'CX-9' => ['2.5L Turbo Petrol (Discontinued)'],
                'RX-8' => ['1.3L Rotary (Renesis)'],
                'RX-7' => ['1.3L Rotary Turbo (Heritage)']
            ],
            'Kia' => [
                'Rio' => ['1.4L Petrol', '1.6L Petrol', '1.2L Petrol (Certain Markets)', '1.0L Turbo Petrol (Certain Markets)'],
                'Forte' => ['2.0L Petrol', '1.6L Turbo Petrol'],
                'K5 (Optima)' => ['2.5L Petrol', '2.0L Petrol', '1.6L Turbo Petrol', '2.0L Hybrid', '2.0L Plug-in Hybrid'],
                'Sportage' => ['2.5L Petrol', '1.6L Turbo Petrol', '1.6L Turbo Hybrid', '1.6L Turbo Plug-in Hybrid', '2.0L Diesel'],
                'Sorento' => ['2.5L Petrol', '1.6L Turbo Hybrid', '1.6L Turbo Plug-in Hybrid', '2.2L Diesel'],
                'Telluride' => ['3.8L V6 Petrol'],
                'Stinger' => ['2.0L Turbo Petrol (Discontinued)', '2.5L Turbo Petrol', '3.3L Twin-Turbo V6 Petrol'],
                'Seltos' => ['2.0L Petrol', '1.6L Turbo Petrol'],
                'EV6' => ['Standard Range RWD Electric', 'Long Range RWD Electric', 'Long Range AWD Electric', 'GT AWD Electric'],
                'Niro' => ['1.6L Hybrid', '1.6L Plug-in Hybrid', 'Electric'],
                'Carnival' => ['3.5L V6 Petrol', '2.2L Diesel'],
                'Soul' => ['2.0L Petrol', '1.6L Turbo Petrol', 'Electric'],
                'Ceed' => ['1.0L Turbo Petrol', '1.5L Turbo Petrol', '1.6L Turbo Petrol', '1.6L Diesel', 'Plug-in Hybrid'],
                'Proceed' => ['1.5L Turbo Petrol', '1.6L Turbo Petrol'],
                'XCeed' => ['1.0L Turbo Petrol', '1.5L Turbo Petrol', '1.6L Turbo Petrol', 'Plug-in Hybrid'],
                'Mohave' => ['3.0L V6 Diesel'],
                'K900' => ['3.3L Twin-Turbo V6 Petrol', '5.0L V8 Petrol'],
            ],
            'Volvo' => [
                'S60' => ['B5 Mild-Hybrid Petrol', 'B4 Mild-Hybrid Diesel', 'T8 Recharge Plug-in Hybrid'],
                'S90' => ['B5 Mild-Hybrid Petrol', 'B4 Mild-Hybrid Diesel', 'T8 Recharge Plug-in Hybrid'],
                'V60' => ['B5 Mild-Hybrid Petrol', 'B4 Mild-Hybrid Diesel', 'T8 Recharge Plug-in Hybrid'],
                'V90' => ['B5 Mild-Hybrid Petrol', 'B4 Mild-Hybrid Diesel', 'T8 Recharge Plug-in Hybrid'],
                'XC40' => ['B4 Mild-Hybrid Petrol', 'B4 Mild-Hybrid Diesel', 'Recharge P8 Electric', 'T4 Recharge Plug-in Hybrid', 'T5 Recharge Plug-in Hybrid'],
                'XC60' => ['B5 Mild-Hybrid Petrol', 'B4 Mild-Hybrid Diesel', 'T8 Recharge Plug-in Hybrid'],
                'XC90' => ['B5 Mild-Hybrid Petrol', 'B5 Mild-Hybrid Diesel', 'T8 Recharge Plug-in Hybrid', 'EX90 Electric'],
                'C40' => ['Recharge P8 Electric'],
                'EX30' => ['Single Motor Electric', 'Twin Motor Performance Electric'],
                'EX90' => ['Twin Motor Electric'],
            ],
            'Jaguar' => [
                'F-PACE' => ['2.0L Petrol P250', '3.0L Diesel D300', 'P400 Mild-Hybrid Petrol', 'P400e Plug-in Hybrid', 'SVR 5.0L V8 Supercharged'],
                'E-PACE' => ['2.0L Petrol P200/P250/P300', '2.0L Diesel D165/D200', 'P300e Plug-in Hybrid'],
                'I-PACE' => ['EV400 Electric AWD'],
                'XE' => ['2.0L Petrol P250/P300', '2.0L Diesel D200 Mild-Hybrid'],
                'XF' => ['2.0L Petrol P250/P300', '2.0L Diesel D200 Mild-Hybrid', '5.0L V8 Supercharged (SVR, Discontinued)'],
                'F-Type' => ['2.0L Turbo P300', '3.0L V6 P380 Supercharged', '5.0L V8 P450/P575 Supercharged (R & SVR)']
            ],
            'Land Rover' => [
                'Range Rover' => ['3.0L Diesel D300/D350 Mild-Hybrid', '3.0L Petrol P400 Mild-Hybrid', '4.4L V8 Twin-Turbo P530', 'P440e/P510e Plug-in Hybrid', 'SV P615 (5.0L V8 Supercharged, Discontinued)'],
                'Range Rover Sport' => ['3.0L Diesel D250/D300/D350 MHEV', '3.0L Petrol P400 MHEV', '4.4L V8 Twin-Turbo P530', 'P460e/P550e Plug-in Hybrid'],
                'Range Rover Velar' => ['2.0L Petrol P250', '3.0L Petrol P400 MHEV', '2.0L Diesel D200', 'P400e Plug-in Hybrid'],
                'Range Rover Evoque' => ['2.0L Petrol P200/P250', '2.0L Diesel D165/D200', 'P300e Plug-in Hybrid'],
                'Defender' => ['2.0L Petrol P300', '3.0L Petrol P400 MHEV', '3.0L Diesel D250/D300/D350 MHEV', '5.0L V8 P525/P625 Supercharged'],
                'Discovery' => ['2.0L Petrol P300', '3.0L Petrol P360 MHEV', '3.0L Diesel D250/D300 MHEV'],
                'Discovery Sport' => ['2.0L Petrol P200/P250', '2.0L Diesel D165/D200', 'P300e Plug-in Hybrid']
            ],
            'Fiat' => [
                '500' => ['1.0L Hybrid', '1.2L Petrol', '1.4L Petrol', '500e Electric'],
                '500X' => ['1.0L Petrol', '1.3L Petrol', '1.6L Diesel'],
                'Panda' => ['1.0L Hybrid', '1.2L Petrol', '0.9L TwinAir Petrol', '1.3L Diesel'],
                'Tipo' => ['1.0L Petrol', '1.3L Diesel', '1.6L Diesel'],
                'Ducato' => ['2.2L Diesel', '2.3L Diesel', 'Ducato Electric'],
                'Scudo' => ['1.5L Diesel', '2.0L Diesel', 'Scudo Electric'],
                'Fullback' => ['2.4L Diesel'],
                'Ulysse' => ['2.0L Diesel', 'Ulysse Electric']
            ],
            'Tesla' => [
                'Model S' => ['Long Range Electric', 'Plaid Electric'],
                'Model 3' => ['Standard Range Plus Electric', 'Long Range Electric', 'Performance Electric'],
                'Model X' => ['Long Range Electric', 'Plaid Electric'],
                'Model Y' => ['Standard Range Electric', 'Long Range Electric', 'Performance Electric']
            ],
            'Chrysler' => [
                '300' => ['3.6L V6', '5.7L V8'],
                'Pacifica' => ['3.6L V6', 'Hybrid'],
                'Voyager' => ['3.6L V6'],
                'Aspen' => ['4.7L V8', '5.7L V8']
            ],
            'Dodge' => [
                'Charger' => ['3.6L V6', '5.7L V8', '6.2L Supercharged V8'],
                'Challenger' => ['3.6L V6', '5.7L V8', '6.2L Supercharged V8'],
                'Durango' => ['3.6L V6', '5.7L V8'],
                'Journey' => ['2.4L I4', '3.6L V6'],
                'Ram 1500' => ['3.6L V6', '5.7L V8']
            ],
            'GMC' => [
                'Sierra' => ['4.3L V6', '5.3L V8', '6.2L V8'],
                'Terrain' => ['1.5L Turbo', '2.0L Turbo'],
                'Acadia' => ['2.5L I4', '3.6L V6'],
                'Yukon' => ['5.3L V8', '6.2L V8'],
                'Canyon' => ['2.5L I4', '3.6L V6']
            ],
            'Nissan' => [
                'Altima' => ['2.5L I4', '2.0L VC Turbo', '2.5L Hybrid (Certain regions)'],
                'Sentra' => ['2.0L I4'],
                'Maxima' => ['3.5L V6'],
                'Rogue' => ['2.5L I4', '1.5L Turbo', '2.0L Hybrid (Certain regions)'],
                'Armada' => ['5.6L V8'],
                'Titan' => ['5.6L V8'],
                '370Z' => ['3.0L V6', '370Z Nismo (3.7L V6)'],
                'Leaf' => ['40 kWh Electric', '62 kWh Electric']
            ],
            'Acura' => [
                'TLX' => ['2.0L Turbo', '3.0L V6'],
                'MDX' => ['3.5L V6', '3.0L Hybrid'],
                'RDX' => ['2.0L Turbo'],
                'ILX' => ['2.4L I4'],
                'ZDX' => ['3.7L V6']
            ],
            'Infiniti' => [
                'Q50' => ['2.0L Turbo', '3.0L V6'],
                'Q60' => ['2.0L Turbo', '3.0L V6'],
                'QX50' => ['2.0L Turbo'],
                'QX60' => ['3.5L V6'],
                'QX80' => ['5.6L V8']
            ],
            'Alfa Romeo' => [
                'Giulia' => ['2.0L Turbo', '2.9L V6 Quadrifoglio', '2.2L Diesel'],
                'Stelvio' => ['2.0L Turbo', '2.9L V6 Quadrifoglio', '2.2L Diesel'],
                '4C' => ['1.75L Turbo', '1.7L Turbo (Previous version)'],
                'Giulietta' => ['1.4L Turbo', '1.6L Diesel', '2.0L Diesel'],
                'Tonale' => ['1.3L Turbo Hybrid', '2.0L Turbo Hybrid']
            ],
            'Mitsubishi' => [
                'Outlander' => ['2.5L I4', '2.4L Hybrid', '2.4L PHEV (Plug-in Hybrid)'],
                'Eclipse Cross' => ['1.5L Turbo', '1.5L Turbo PHEV (Plug-in Hybrid)'],
                'RVR' => ['2.0L I4', '1.8L Diesel (Certain regions)'],
                'Lancer' => ['2.0L I4', '2.0L Turbo (Evolution model)'],
                'Pajero' => ['3.0L V6', '3.2L Diesel (Certain regions)', '3.8L V6 (Certain regions)'],
                'Outlander PHEV' => ['2.4L PHEV (Plug-in Hybrid)']
            ],
            'Lexus' => [
                'ES' => ['2.5L I4', '3.5L V6', 'Hybrid'],
                'RX' => ['2.5L I4', '3.5L V6', 'Hybrid', 'RX 500h (Hybrid Performance)'],
                'NX' => ['2.5L I4', '2.4L Turbo', 'Hybrid', 'NX 450h+ (Plug-in Hybrid)'],
                'LX' => ['5.7L V8', 'LX 600 (3.5L V6 Turbo Hybrid)'],
                'GX' => ['4.6L V8', 'GX 460 (4.6L V8)']
            ],
            'Genesis' => [
                'G70' => ['2.0L Turbo', '3.3L Turbo'],
                'G80' => ['2.5L Turbo', '3.5L Turbo', '5.0L V8'],
                'G90' => ['3.3L Turbo', '5.0L V8']
            ],
            'Pagani' => [
                'Huayra' => ['6.0L V12 Bi-Turbo'],
                'Zonda' => ['7.3L V12', '6.0L V12', '7.3L V12 (Clubsport)', '6.0L V12 (Roadster)'],
                'Huayra Roadster' => ['6.0L V12 Bi-Turbo'],
                'Huayra Roadster BC' => ['6.0L V12 Bi-Turbo']
            ],
            'Bugatti' => [
                'Chiron' => ['8.0L W16'],
                'Veyron' => ['8.0L W16'],
                'Divo' => ['8.0L W16']
            ],
            'Koenigsegg' => [
                'Agera' => ['5.0L V8'],
                'Regera' => ['5.0L V8 Hybrid'],
                'Gemera' => ['2.0L I3 Hybrid']
            ],
        ];
        

        // Create Car Brands, Models, and Motorization Types
        foreach ($brands as $brandName => $models) {
            $brand = new CarBrand();
            $brand->setName($brandName);
            $manager->persist($brand);

            foreach ($models as $modelName => $motorizationTypes) {
                $model = new CarModel();
                $model->setName($modelName);
                $model->setBrand($brand);
                $manager->persist($model);

                foreach ($motorizationTypes as $type) {
                    $motorization = new MotorizationType();
                    $motorization->setType($type);
                    $motorization->setModel($model);
                    $manager->persist($motorization);
                }
            }
        }

        // Create a default user
        $user = new User();
        $user->setEmail('altiballa@gmail.com');
        $user->setName('alti');
        $user->setLastname('balla');
        $user->setPhoneNumber('0605991577');
        $user->setGender('male');
        $user->setPassword('$argon2id$v=19$m=65536,t=3,p=4$pEvuZ5KxA6iGQ47cUa+u5w$p+DAjc9fAoylQpZX3MfHpGawZWfKuqw98bS1HD4jEN8');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

       
       
        // Create countrie, regions and departments

        $albania = new Country();
        $albania->setName('Albania');
        $manager->persist($albania);
        
        $regions = [
            'Qarku i Beratit',
            'Qarku i Dibrës',
            'Qarku i Durrësit', 
            'Qarku i Elbasanit',
            'Qarku i Fierit',
            'Qarku i Gjirokastrës',
            'Qarku i Korçës',
            'Qarku i Kukësit',
            'Qarku i Lezhës',
            'Qarku i Shkodrës',
            'Qarku i Tiranës',
            'Qarku i Vlorës'
        ];

        foreach ($regions as $regionName) {
            $region = new Region();
            $region->setName($regionName);
            $region->setCountry($albania);
            $manager->persist($region);
        }

        
        $kosova = new Country();
        $kosova->setName('Kosova');
        $manager->persist($kosova);

        $regions = [
            'Qarku i Ferizaj',
            'Qarku i Gjakovë',
            'Qarku i Gjilan',
            'Qarku i Mitrovicë',
            'Qarku i Pejë',
            'Qarku i Prishtinë',
            'Qarku i Prizren'
        ];

        foreach ($regions as $regionName) {
            $region = new Region();
            $region->setName($regionName);
            $region->setCountry($kosova);
            $manager->persist($region);
        }

        $importCountries = [
            // European Countries
            'Germany',
            'Italy',
            'Switzerland',
            'Austria',
            'Belgium',
            'Netherlands',
            'France',
            'Spain',
            'Sweden',
            'Norway',
            'Denmark',
            'Finland',
            'Poland',
            'Czech Republic',
            'Slovakia',
            'Hungary',
            'Slovenia',
            'Croatia',
            'Greece',
            'United Kingdom',
            
            // Asian Countries
            'Japan',
            'South Korea',
            'China',
            'Singapore',
            'United Arab Emirates',
            
            // American Countries
            'United States',
            'Canada'
        ];

        foreach ($importCountries as $countryName) {
            $importCountry = new ImportCountry();
            $importCountry->setName($countryName);
            $manager->persist($importCountry);
        }
      
        // Flush all changes to the database
        $manager->flush();
    }
}