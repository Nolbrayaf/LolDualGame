<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Champion;
use App\Models\Spell;

class ImportChampionsData extends Command
{
    protected $signature = 'import:champions-data';
    protected $description = 'Import all champion data';

    public function handle()
    {
        $client = new Client();
        $championsResponse = $client->get('https://ddragon.leagueoflegends.com/cdn/13.24.1/data/fr_FR/champion.json');
        $championsData = json_decode($championsResponse->getBody(), true);

        foreach ($championsData['data'] as $champion) {
            $this->importChampion($client, $champion['id']);
        }

        $this->info("C'EST FINI CHEF !");
    }

    private function importChampion($client, $championId)
    {
        $championResponse = $client->get("https://ddragon.leagueoflegends.com/cdn/13.24.1/data/fr_FR/champion/{$championId}.json");
        $championData = json_decode($championResponse->getBody(), true)['data'][$championId];

        $splashArtPath = $this->downloadImage($client, "img/champion/splash/{$championId}_0.jpg", $championData['name']);
        $dualArtPath = $this->downloadImage($client, "img/champion/loading/{$championId}_0.jpg", $championData['name']);
        $squareArtPath = $this->downloadImage($client, "13.24.1/img/champion/{$championId}.png", $championData['name']);

        $champion = Champion::updateOrCreate(
            ['key' => $championId],
            [
                'name' => $championData['name'],
                'title' => $championData['title'],
                'info' => json_encode($championData['info']),
                'tags' => json_encode($championData['tags']),
                'partype' => $championData['partype'],
                'stats' => json_encode($championData['stats']),
                'difficulty' => $championData['info']['difficulty'],
                'splash_art_path' => $splashArtPath,
                'square_art_path' => $squareArtPath,
                'dual_art_path' => $dualArtPath,
                'description' => $championData['lore'],
                'required_level' => rand(1, 100)
            ]
        );

        $this->importSpells($client, $champion, $championData['spells']);
    }

    private function importSpells($client, $champion, $spellsData)
    {
        foreach ($spellsData as $spellData) {
            $effectType = $this->determineEffectType($spellData);
            $imagePath = $this->downloadImage($client, "13.24.1/img/spell/{$spellData['id']}.png", $champion->name, true);
            $effects = [null, $spellData['effect'][1] ?? null];

            Spell::updateOrCreate(
                ['champion_id' => $champion->id, 'name' => $spellData['name']],
                [
                    'description' => $spellData['description'],
                    'max_rank' => count($spellData['cooldown']),
                    'image_path' => $imagePath,
                    'cooldowns' => json_encode($spellData['cooldown']),
                    'cost' => json_encode($spellData['cost']),
                    'effect' => json_encode($effects),
                    'effect_type' => $effectType,
                    'is_passive' => false
                ]
            );
        }
    }

    private function downloadImage($client, $url, $championName, $isSpellImage = false)
    {
        $baseDir = storage_path("app/public/champions");
        $championDir = $baseDir . '/' . $championName;

        // Créer le dossier du champions
        if (!file_exists($championDir)) {
            mkdir($championDir, 0755, true);
        }

        // Déterminer le dossier de destination
        $destinationDir = $championDir;
        if ($isSpellImage) {
            $spellsDir = $championDir . '/spells';
            if (!file_exists($spellsDir)) {
                mkdir($spellsDir, 0755, true);
            }
            $destinationDir = $spellsDir;
        }

        $imagePath = $destinationDir . '/' . basename($url);

        $response = $client->get("https://ddragon.leagueoflegends.com/cdn/{$url}");
        file_put_contents($imagePath, $response->getBody());

        return "champions/" . $championName . ($isSpellImage ? "/spells/" : "/") . basename($url);
    }


    private function determineEffectType($spellData)
    {
        if (strpos($spellData['description'], 'soigne') !== false) {
            return 'heal';
        } elseif (strpos($spellData['description'], 'dégâts') !== false) {
            return 'damage';
        } elseif (strpos($spellData['description'], 'armure') !== false) {
            return 'armor';
        } else {
            return 'other';
        }
    }
}
