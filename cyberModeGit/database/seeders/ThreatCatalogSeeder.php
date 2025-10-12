<?php

namespace Database\Seeders;

use App\Models\ThreatCatalog;
use Illuminate\Database\Seeder;

class ThreatCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ThreatCatalog::create([
            "id" => 1,
            "number" => 'NT-1',
            "threat_grouping_id" => 1,
            "name" => 'Drought & Water Shortage',
            "description" => 'Regardless of geographic location, periods of reduced rainfall are expected. For non-agricultural industries, drought may not be impactful to operations until it reaches the extent of water rationing.',
            "order" => 1
        ]);
        ThreatCatalog::create([
            "id" => 2,
            "number" => 'NT-2',
            "threat_grouping_id" => 1,
            "name" => 'Earthquakes',
            "description" => 'Earthquakes are sudden rolling or shaking events caused by movement under the earth’s surface. Although earthquakes usually last less than one minute, the scope of devastation can be widespread and have long-lasting impact.',
            "order" => 2
        ]);
        ThreatCatalog::create([
            "id" => 3,
            "number" => 'NT-3',
            "threat_grouping_id" => 1,
            "name" => 'Fire & Wildfires',
            "description" => 'Regardless of geographic location or even building material, fire is a concern for every business. When thinking of a fire in a building, envision a total loss to all technology hardware, including backup tapes, and all paper files being consumed in the fire.',
            "order" => 3
        ]);
        ThreatCatalog::create([
            "id" => 4,
            "number" => 'NT-4',
            "threat_grouping_id" => 1,
            "name" => 'Floods',
            "description" => 'Flooding is the most common of natural hazards and requires an understanding of the local environment, including floodplains and the frequency of flooding events. Location of critical technologies should be considered (e.g., server room is in the basement or first floor of the facility).',
            "order" => 4
        ]);
        ThreatCatalog::create([
            "id" => 5,
            "number" => 'NT-5',
            "threat_grouping_id" => 1,
            "name" => 'Hurricanes & Tropical Storms',
            "description" => 'Hurricanes and tropical storms are among the most powerful natural disasters because of their size and destructive potential. In addition to high winds, regional flooding and infrastructure damage should be considered when assessing hurricanes and tropical storms.',
            "order" => 5
        ]);
        ThreatCatalog::create([
            "id" => 6,
            "number" => 'NT-6',
            "threat_grouping_id" => 1,
            "name" => 'Landslides & Debris Flow',
            "description" => 'Landslides occur throughout the world and can be caused by a variety of factors including earthquakes, storms, volcanic eruptions, fire, and by human modification of land. Landslides can occur quickly, often with little notice. Location of critical technologies should be considered (e.g., server room is in the basement or first floor of the facility).',
            "order" => 6
        ]);
        ThreatCatalog::create([
            "id" => 7,
            "number" => 'NT-7',
            "threat_grouping_id" => 1,
            "name" => 'Pandemic (Disease) Outbreaks',
            "description" => 'Due to the wide variety of possible scenarios, consideration should be given both to the magnitude of what can reasonably happen during a pandemic outbreak (e.g., COVID-19, Influenza, SARS, Ebola, etc.) and what actions the business can be taken to help lessen the impact of a  pandemic on operations.',
            "order" => 7
        ]);
        ThreatCatalog::create([
            "id" => 8,
            "number" => 'NT-8',
            "threat_grouping_id" => 1,
            "name" => 'Severe Weather',
            "description" => 'Severe weather is a broad category of meteorological events that include events that range from damaging winds to hail.',
            "order" => 8
        ]);
        ThreatCatalog::create([
            "id" => 9,
            "number" => 'NT-9',
            "threat_grouping_id" => 1,
            "name" => 'Space Weather',
            "description" => 'Space weather includes natural events in space that can affect the near-earth environment and satellites. Most commonly, this is associated with solar flares from the Sun, so an understanding of how solar flares may impact the business is of critical importance in assessing this threat.',
            "order" => 9
        ]);
        ThreatCatalog::create([
            "id" => 10,
            "number" => 'NT-10',
            "threat_grouping_id" => 1,
            "name" => 'Thunderstorms & Lightning',
            "description" => 'Thunderstorms are most prevalent in the spring and summer months and generally occur during the afternoon and evening hours, but they can occur year-round and at all hours. Many hazardous weather events are associated with thunderstorms. Under the right conditions, rainfall from thunderstorms causes flash flooding and lightning is responsible for equipment damage, fires and fatalities.',
            "order" => 10
        ]);
        ThreatCatalog::create([
            "id" => 11,
            "number" => 'NT-11',
            "threat_grouping_id" => 1,
            "name" => 'Tornadoes',
            "description" => 'Tornadoes occur in many parts of the world, including the US, Australia, Europe, Africa, Asia, and South America. Tornadoes can happen at any time of year and occur at any time of day or night, but most tornadoes occur between 4–9 p.m. Tornadoes (with winds up to about 300 mph) can destroy all but the best-built man-made structures.',
            "order" => 11
        ]);
        ThreatCatalog::create([
            "id" => 12,
            "number" => 'NT-12',
            "threat_grouping_id" => 1,
            "name" => 'Tsunamis',
            "description" => 'All tsunamis are potentially dangerous, even though they may not damage every coastline they strike. A tsunami can strike anywhere along most of the US coastline. The most destructive tsunamis have occurred along the coasts of California, Oregon, Washington, Alaska and Hawaii.',
            "order" => 12
        ]);
        ThreatCatalog::create([
            "id" => 13,
            "number" => 'NT-13',
            "threat_grouping_id" => 1,
            "name" => 'Volcanoes',
            "description" => 'While volcanoes are geographically fixed objects, volcanic fallout can have significant downwind impacts for thousands of miles. Far outside of the blast zone, volcanoes can significantly damage or degrade transportation systems and also cause electrical grids to fail.',
            "order" => 13
        ]);
        ThreatCatalog::create([
            "id" => 14,
            "number" => 'NT-14',
            "threat_grouping_id" => 1,
            "name" => 'Winter Storms & Extreme Cold',
            "description" => 'Winter storms is a broad category of meteorological events that include events that range from ice storms, to heavy snowfall, to unseasonably (e.g., record breaking) cold temperatures. Winter storms can significantly impact business operations and transportation systems over a wide geographic region.',
            "order" => 14
        ]);
        ThreatCatalog::create([
            "id" => 15,
            "number" => 'MT-1',
            "threat_grouping_id" => 2,
            "name" => 'Civil or Political Unrest',
            "description" => 'Civil or political unrest can be singular or wide-spread events that can be unexpected and unpredictable. These events can occur anywhere, at any time.',
            "order" => 15
        ]);
        ThreatCatalog::create([
            "id" => 16,
            "number" => 'MT-2',
            "threat_grouping_id" => 2,
            "name" => 'Hacking & Other Cybersecurity Crimes',
            "description" => 'Unlike physical threats that prompt immediate action (e.g., \"stop, drop, and roll\" in the event of a fire), cyber incidents are often difficult to identify as the incident is occurring. Detection generally occurs after the incident has occurred, with the exception of \"denial of service\" attacks. The spectrum of cybersecurity risks is limitless and threats can have wide-ranging effects on the individual, organizational, geographic, and national levels.',
            "order" => 16
        ]);
        ThreatCatalog::create([
            "id" => 17,
            "number" => 'MT-3',
            "threat_grouping_id" => 2,
            "name" => 'Hazardous Materials Emergencies',
            "description" => 'Hazardous materials emergencies are focused on accidental disasters that occur in industrialized nations. These incidents can range from industrial chemical spills to groundwater contamination.',
            "order" => 17
        ]);
        ThreatCatalog::create([
            "id" => 18,
            "number" => 'MT-4',
            "threat_grouping_id" => 2,
            "name" => 'Nuclear, Biological and Chemical (NBC) Weapons',
            "description" => 'The use of NBC weapons are in the possible arsenals of international terrorists and it must be a consideration. Terrorist use of a “dirty bomb” — is considered far more likely than use of a traditional nuclear explosive device. This may be a combination a conventional explosive device with radioactive / chemical / biological material and be designed to scatter lethal and sub-lethal amounts of material over a wide area.',
            "order" => 18
        ]);
        ThreatCatalog::create([
            "id" => 19,
            "number" => 'MT-5',
            "threat_grouping_id" => 2,
            "name" => 'Physical Crime',
            "description" => 'Physical crime includes \"traditional\" crimes of opportunity. These incidents can range from theft, to vandalism, riots, looting, arson and other forms of criminal activities.',
            "order" => 19
        ]);
        ThreatCatalog::create([
            "id" => 20,
            "number" => 'MT-6',
            "threat_grouping_id" => 2,
            "name" => 'Terrorism & Armed Attacks',
            "description" => 'Armed attacks, regardless of the motivation of the attacker, can impact a businesses. Scenarios can range from single actors (e.g., \"disgruntled\" employee) all the way to a coordinated terrorist attack by multiple assailants. These incidents can range from the use of blade weapons (e.g., knives), blunt objects (e.g., clubs), to firearms and explosives.',
            "order" => 20
        ]);
        ThreatCatalog::create([
            "id" => 21,
            "number" => 'MT-7',
            "threat_grouping_id" => 2,
            "name" => 'Utility Service Disruption',
            "description" => 'Utility service disruptions are focused on the sustained loss of electricity, Internet, natural gas, water, and/or sanitation services. These incidents can have a variety of causes but  directly impact the fulfillment of utility services that your business needs to operate.',
            "order" => 21
        ]);
    }
}
