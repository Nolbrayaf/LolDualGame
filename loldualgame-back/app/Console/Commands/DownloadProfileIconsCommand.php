<?php

namespace App\Console\Commands;

use App\Models\ProfileIcon;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class DownloadProfileIconsCommand extends Command
{
    protected $signature = 'download:profile-icons';
    protected $description = 'Download all profile icons';

    public function handle()
    {
        $index = 0;
        $client = new Client();
        $response = $client->get('https://ddragon.leagueoflegends.com/cdn/13.24.1/data/fr_FR/profileicon.json');
        $data = json_decode($response->getBody(), true);

        foreach ($data['data'] as $item) {
            if ($index % 5 == 0) {
                $path = $this->downloadImage($item['image']['full'], $item['id']);

                ProfileIcon::updateOrCreate(
                    ['id' => $item['id']],
                    ['image_path' => $path]
                );
            }
            $index++;
        }
        $this->info('Toutes les icones ont été télechargées et entrées dans la base de données.');
    }

    private function downloadImage($imageName, $id)
    {
        $client = new Client();
        $url = "https://ddragon.leagueoflegends.com/cdn/13.24.1/img/profileicon/{$imageName}";
        $response = $client->get($url);
        $path = "profile_icons/{$id}.png"; // Chemin relatif pour la base de données

        file_put_contents(storage_path("app/public/{$path}"), $response->getBody());
        return $path;
    }
}
