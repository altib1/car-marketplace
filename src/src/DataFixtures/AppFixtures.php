<?php

namespace App\DataFixtures;

use App\Entity\CarBrand;
use App\Entity\CarModel;
use App\Entity\MotorizationType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $brands = [
            'Toyota' => [
                'Corolla' => ['1.8L Petrol', '1.8L Hybrid'],
                'Camry' => ['2.5L Petrol', '2.5L Hybrid'],
                'RAV4' => ['2.0L Petrol', '2.5L Hybrid'],
                'Prius' => ['1.8L Hybrid'],
                'Highlander' => ['3.5L Petrol', '2.5L Hybrid'],
                'Tacoma' => ['3.5L Petrol'],
                'Supra' => ['3.0L Petrol'],
                'Yaris' => ['1.5L Petrol', '1.5L Hybrid'],
                'Land Cruiser' => ['4.0L Petrol', '2.8L Diesel']
            ],
            'Ford' => [
                'Mustang' => ['5.0L Petrol', '2.3L Petrol'],
                'F-150' => ['3.5L Petrol', '5.0L Petrol'],
                'Explorer' => ['2.3L Petrol', '3.0L Hybrid'],
                'Escape' => ['1.5L Petrol', '2.5L Hybrid'],
                'Focus' => ['1.0L Petrol', '1.5L Diesel'],
                'Fiesta' => ['1.0L Petrol', '1.5L Diesel'],
                'Edge' => ['2.0L Petrol', '2.7L Petrol'],
                'Bronco' => ['2.3L Petrol', '2.7L Petrol'],
                'Ranger' => ['2.3L Petrol', '2.0L Diesel'],
                'Transit' => ['3.5L Petrol', '2.0L Diesel']
            ],
            'BMW' => [
                '3 Series' => ['320i', '330i', '330e', '340i'],
                '5 Series' => ['520i', '530i', '530e', '540i'],
                '7 Series' => ['740i', '750i', '745e'],
                'X3' => ['xDrive20i', 'xDrive30i', 'xDrive30e'],
                'X5' => ['xDrive40i', 'xDrive45e', 'xDrive50i'],
                'X7' => ['xDrive40i', 'xDrive50i'],
                'Z4' => ['sDrive20i', 'sDrive30i', 'M40i'],
                'M3' => ['M3'],
                'M5' => ['M5'],
                'i8' => ['i8']
            ],
            'Mercedes-Benz' => [
                'C-Class' => ['C 180', 'C 200', 'C 220d', 'C 300'],
                'E-Class' => ['E 200', 'E 220d', 'E 300', 'E 400'],
                'S-Class' => ['S 450', 'S 500', 'S 560'],
                'G-Class' => ['G 350d', 'G 500', 'G 63 AMG'],
                'GLC' => ['GLC 200', 'GLC 220d', 'GLC 300'],
                'GLE' => ['GLE 350d', 'GLE 400d', 'GLE 450'],
                'GLS' => ['GLS 400d', 'GLS 580'],
                'AMG GT' => ['GT 53', 'GT 63'],
                'A-Class' => ['A 180', 'A 200', 'A 220d'],
                'CLA' => ['CLA 200', 'CLA 220d', 'CLA 250']
            ],
            'Honda' => [
                'Civic' => ['2.0L Petrol', '1.5L Turbo Petrol'],
                'Accord' => ['2.0L Petrol', '2.0L Hybrid'],
                'CR-V' => ['1.5L Turbo Petrol', '2.0L Hybrid'],
                'HR-V' => ['1.8L Petrol'],
                'Pilot' => ['3.5L Petrol'],
                'Ridgeline' => ['3.5L Petrol'],
                'Insight' => ['1.5L Hybrid'],
                'Fit' => ['1.5L Petrol'],
                'Odyssey' => ['3.5L Petrol']
            ],
            'Audi' => [
                'A3' => ['30 TFSI', '35 TFSI', '40 TFSI', 'S3'],
                'A4' => ['35 TFSI', '40 TFSI', 'A4 Avant'],
                'A6' => ['40 TFSI', '45 TFSI', 'A6 Avant'],
                'A8' => ['A8 L 55 TFSI', 'A8 L 60 TFSI'],
                'Q3' => ['Q3 35 TFSI', 'Q3 40 TFSI'],
                'Q5' => ['Q5 40 TFSI', 'Q5 55 TFSI'],
                'Q7' => ['Q7 55 TFSI', 'Q7 60 TFSI'],
                'Q8' => ['Q8 55 TFSI'],
                'TT' => ['TT Coupe', 'TT Roadster'],
                'R8' => ['R8 Coupe', 'R8 Spyder']
            ],
            'Chevrolet' => [
                'Silverado' => ['4.3L V6', '5.3L V8', '6.2L V8'],
                'Malibu' => ['1.5L Turbo', '2.0L Turbo'],
                'Equinox' => ['1.5L Turbo', '2.0L Turbo'],
                'Tahoe' => ['5.3L V8', '6.2L V8'],
                'Traverse' => ['3.6L V6'],
                'Camaro' => ['2.0L Turbo', '6.2L V8'],
                'Corvette' => ['6.2L V8', '5.5L V8'],
                'Blazer' => ['2.0L Turbo', '3.6L V6'],
                'Trailblazer' => ['1.3L Turbo'],
                'Spark' => ['1.4L Petrol']
            ],
            'Nissan' => [
                'Altima' => ['2.5L Petrol', '2.0L Turbo'],
                'Maxima' => ['3.5L V6'],
                'Rogue' => ['2.5L Petrol', '1.5L Turbo'],
                'Murano' => ['3.5L V6'],
                'Pathfinder' => ['3.5L V6'],
                'Sentra' => ['2.0L Petrol'],
                'Versa' => ['1.6L Petrol'],
                'Titan' => ['5.6L V8'],
                'Armada' => ['5.6L V8'],
                'Juke' => ['1.6L Turbo']
            ],
            'Hyundai' => [
                'Elantra' => ['2.0L Petrol', '1.6L Turbo Petrol'],
                'Sonata' => ['2.5L Petrol', '2.0L Turbo Petrol'],
                'Tucson' => ['2.5L Petrol', '1.6L Turbo'],
                'Santa Fe' => ['2.5L Petrol', '2.2L Diesel'],
                'Kona' => ['2.0L Petrol', '1.6L Turbo'],
                'Palisae' => ['3.8L Petrol'],
                'Venue' => ['1.6L Petrol'],
                'Ioniq' => ['1.6L Hybrid', 'Electric'],
                'Genesis' => ['3.3L Turbo V6', '5.0L V8']
            ],
            'Volkswagen' => [
                'Golf' => ['1.4L Petrol', '2.0L Diesel', '1.5L TSI'],
                'Passat' => ['1.5L TSI', '2.0L TDI', '2.0L Petrol'],
                'Tiguan' => ['1.5L TSI', '2.0L TDI'],
                'Jetta' => ['1.4L Petrol', '1.8L Turbo', '2.0L Diesel'],
                'Atlas' => ['2.0L Turbo', '3.6L V6'],
                'Beetle' => ['1.8L Turbo', '2.0L Turbo'],
                'Polo' => ['1.0L Petrol', '1.6L Diesel'],
                'T-Roc' => ['1.0L TSI', '2.0L TDI'],
                'Arteon' => ['2.0L TSI', '2.0L TDI'],
                'ID.4' => ['Electric']
            ],
            'Subaru' => [
                'Outback' => ['2.5L Petrol', '2.4L Turbo'],
                'Forester' => ['2.5L Petrol', '2.0L Hybrid'],
                'Crosstrek' => ['2.0L Petrol', '2.5L Petrol'],
                'Impreza' => ['2.0L Petrol', '2.5L Turbo'],
                'Ascent' => ['2.4L Turbo'],
                'BRZ' => ['2.4L Petrol'],
                'Legacy' => ['2.5L Petrol', '2.4L Turbo'],
                'WRX' => ['2.0L Turbo', '2.4L Turbo']
            ],
            'Porsche' => [
                '911' => ['Carrera', 'Turbo', 'GT3'],
                'Cayenne' => ['Cayenne', 'Cayenne S', 'Cayenne E-Hybrid'],
                'Macan' => ['Macan', 'Macan S', 'Macan GTS'],
                'Panamera' => ['Panamera', 'Panamera 4', 'Panamera Turbo'],
                'Taycan' => ['Taycan 4S', 'Taycan Turbo', 'Taycan Turbo S']
            ],
            'Mazda' => [
                'Mazda3' => ['2.0L Petrol', '2.5L Petrol', '2.5L Diesel'],
                'Mazda6' => ['2.5L Petrol', '2.2L Diesel'],
                'CX-5' => ['2.5L Petrol', '2.2L Diesel'],
                'CX-30' => ['2.0L Petrol', '2.5L Petrol'],
                'MX-5 Miata' => ['2.0L Petrol'],
                'CX-9' => ['2.5L Petrol'],
                'RX-8' => ['1.3L Rotary']
            ],
            'Kia' => [
                'Forte' => ['2.0L Petrol', '1.6L Turbo'],
                'Optima' => ['2.4L Petrol', '2.0L Turbo'],
                'Sportage' => ['2.4L Petrol', '2.0L Diesel', '1.6L Turbo'],
                'Sorento' => ['2.5L Petrol', '2.2L Diesel'],
                'Telluride' => ['3.8L V6'],
                'Stinger' => ['2.0L Turbo', '3.3L Turbo'],
                'Seltos' => ['2.0L Petrol', '1.6L Turbo']
            ],
            'Volvo' => [
                'S60' => ['2.0L Petrol', '2.0L Diesel', 'T8 Hybrid'],
                'S90' => ['2.0L Petrol', '2.0L Diesel', 'T8 Hybrid'],
                'V60' => ['2.0L Petrol', '2.0L Diesel', 'T8 Hybrid'],
                'XC40' => ['2.0L Petrol', '2.0L Diesel', 'Recharge Electric'],
                'XC60' => ['2.0L Petrol', '2.0L Diesel', 'T8 Hybrid'],
                'XC90' => ['2.0L Petrol', '2.0L Diesel', 'T8 Hybrid']
            ],
            'Jaguar' => [
                'F-PACE' => ['2.0L Petrol', '3.0L Diesel'],
                'E-PACE' => ['2.0L Petrol', '2.0L Diesel'],
                'I-PACE' => ['Electric'],
                'XE' => ['2.0L Petrol', '2.0L Diesel'],
                'XF' => ['2.0L Petrol', '3.0L Diesel', '5.0L V8'],
                'F-Type' => ['2.0L Turbo', '3.0L V6', '5.0L V8']
            ],
            'Land Rover' => [
                'Range Rover' => ['3.0L Diesel', '5.0L V8'],
                'Discovery' => ['2.0L Petrol', '3.0L Diesel'],
                'Evoque' => ['2.0L Petrol', '2.0L Diesel'],
                'Defender' => ['2.0L Petrol', '3.0L Diesel'],
                'Velar' => ['2.0L Petrol', '2.0L Diesel']
            ],
            'Fiat' => [
                '500' => ['1.2L Petrol', '1.4L Petrol'],
                'Panda' => ['1.2L Petrol', '1.3L Diesel'],
                'Tipo' => ['1.4L Petrol', '1.6L Diesel'],
                'Ducato' => ['2.3L Diesel', '2.0L Petrol'],
                'Fullback' => ['2.4L Diesel']
            ],
            'Tesla' => [
                'Model S' => ['Electric'],
                'Model 3' => ['Electric'],
                'Model X' => ['Electric'],
                'Model Y' => ['Electric']
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
                'Altima' => ['2.5L I4', '2.0L VC Turbo'],
                'Sentra' => ['2.0L I4'],
                'Maxima' => ['3.5L V6'],
                'Rogue' => ['2.5L I4', '1.5L Turbo'],
                'Armada' => ['5.6L V8'],
                'Titan' => ['5.6L V8'],
                '370Z' => ['3.0L V6']
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
                'Giulia' => ['2.0L Turbo', '2.9L V6'],
                'Stelvio' => ['2.0L Turbo', '2.9L V6'],
                '4C' => ['1.75L Turbo'],
                'Giulietta' => ['1.4L Turbo']
            ],
            'Mitsubishi' => [
                'Outlander' => ['2.5L I4', '2.4L Hybrid'],
                'Eclipse Cross' => ['1.5L Turbo'],
                'RVR' => ['2.0L I4'],
                'Lancer' => ['2.0L I4'],
                'Pajero' => ['3.0L V6']
            ],
            'Lexus' => [
                'ES' => ['2.5L I4', '3.5L V6', 'Hybrid'],
                'RX' => ['2.5L I4', '3.5L V6', 'Hybrid'],
                'NX' => ['2.5L I4', '2.4L Turbo', 'Hybrid'],
                'LX' => ['5.7L V8'],
                'GX' => ['4.6L V8']
            ],
            'Genesis' => [
                'G70' => ['2.0L Turbo', '3.3L Turbo'],
                'G80' => ['2.5L Turbo', '3.5L Turbo', '5.0L V8'],
                'G90' => ['3.3L Turbo', '5.0L V8']
            ],
            'Pagani' => [
                'Huayra' => ['6.0L V12'],
                'Zonda' => ['7.3L V12'],
                'Huayra Roadster' => ['6.0L V12']
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
            // Add other brands, models, and motorization types here
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

        // Flush all changes to the database
        $manager->flush();
    }
}