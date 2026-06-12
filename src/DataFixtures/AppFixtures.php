<?php

namespace App\DataFixtures;

use App\Entity\Editor;
use App\Entity\Game;
use App\Entity\Genre;
use App\Entity\Review;
use App\Entity\User;
use App\Entity\WishlistItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@allgames.test');
        $admin->setUsername('Admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $manager->persist($admin);

        $users = [];
        foreach (['alice' => 'Alice', 'bob' => 'Bob', 'charlie' => 'Charlie'] as $login => $name) {
            $user = new User();
            $user->setEmail($login.'@allgames.test');
            $user->setUsername($name);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $manager->persist($user);
            $users[] = $user;
        }

        $editorNames = ['CD Projekt Red', 'Rockstar Games', 'Valve', 'Nintendo', 'FromSoftware', 'Mojang Studios'];
        $editors = [];
        foreach ($editorNames as $name) {
            $editor = new Editor();
            $editor->setName($name);
            $manager->persist($editor);
            $editors[$name] = $editor;
        }

        $genreNames = ['RPG', 'Action', 'Adventure', 'Open World', 'FPS', 'Sandbox', 'Souls-like', 'Indie'];
        $genres = [];
        foreach ($genreNames as $name) {
            $genre = new Genre();
            $genre->setName($name);
            $manager->persist($genre);
            $genres[$name] = $genre;
        }

        $gamesData = [
            ['The Witcher 3: Wild Hunt', 'CD Projekt Red', ['RPG', 'Open World', 'Adventure'], '2015-05-19', 'A story-driven open world RPG set in a visually stunning fantasy universe full of meaningful choices and impactful consequences.', 'the-witcher-3.jpg'],
            ['Cyberpunk 2077', 'CD Projekt Red', ['RPG', 'Open World', 'FPS'], '2020-12-10', 'An open-world action-adventure story set in Night City, a megalopolis obsessed with power, glamour and body modification.', 'cyberpunk-2077.jpg'],
            ['Grand Theft Auto V', 'Rockstar Games', ['Action', 'Open World'], '2013-09-17', 'A sprawling open-world crime epic set in the city of Los Santos, following three very different criminals.', 'gta-v.jpg'],
            ['Red Dead Redemption 2', 'Rockstar Games', ['Action', 'Open World', 'Adventure'], '2018-10-26', 'An epic tale of life in America at the dawn of the modern age, following outlaw Arthur Morgan and the Van der Linde gang.', 'red-dead-redemption-2.jpg'],
            ['Half-Life: Alyx', 'Valve', ['FPS', 'Action'], '2020-03-23', 'Valve\'s flagship VR game and a return to the Half-Life series, set between the events of Half-Life and Half-Life 2.', 'half-life-alyx.jpg'],
            ['The Legend of Zelda: Breath of the Wild', 'Nintendo', ['Adventure', 'Open World', 'Action'], '2017-03-03', 'Step into a world of discovery, exploration and adventure in this open-air adventure across the vast kingdom of Hyrule.', 'breath-of-the-wild.jpg'],
            ['Elden Ring', 'FromSoftware', ['RPG', 'Souls-like', 'Open World'], '2022-02-25', 'A fantasy action-RPG adventure set in a world created by Hidetaka Miyazaki and George R. R. Martin.', 'elden-ring.jpg'],
            ['Dark Souls III', 'FromSoftware', ['RPG', 'Souls-like', 'Action'], '2016-04-12', 'The latest chapter in the critically acclaimed Dark Souls series, with intense and challenging combat.', 'dark-souls-3.jpg'],
            ['Minecraft', 'Mojang Studios', ['Sandbox', 'Adventure', 'Indie'], '2011-11-18', 'A game about placing blocks and going on adventures. Build anything you can imagine in a procedurally generated world.', 'minecraft.png'],
        ];

        $games = [];
        foreach ($gamesData as [$name, $editorName, $gameGenres, $date, $description, $image]) {
            $game = new Game();
            $game->setName($name);
            $game->setDescription($description);
            $game->setReleaseDate(new \DateTimeImmutable($date));
            $game->setEditor($editors[$editorName]);
            $game->setImageName($image);
            foreach ($gameGenres as $g) {
                $game->addGenre($genres[$g]);
            }
            $manager->persist($game);
            $games[] = $game;
        }

        $comments = [
            'Absolutely loved every minute of it!',
            'A masterpiece, highly recommended.',
            'Solid game but a bit too long for my taste.',
            'Great atmosphere and gameplay.',
            'Not for everyone, but I enjoyed it.',
        ];

        foreach ($users as $i => $user) {
            for ($j = 0; $j < 3; $j++) {
                $item = new WishlistItem();
                $item->setUser($user);
                $item->setGame($games[($i + $j) % count($games)]);
                $manager->persist($item);
            }

            for ($j = 0; $j < 2; $j++) {
                $review = new Review();
                $review->setUser($user);
                $review->setGame($games[($i + $j * 2) % count($games)]);
                $review->setReview(($i + $j) % 3 !== 0);
                $review->setComment($comments[($i + $j) % count($comments)]);
                $manager->persist($review);
            }
        }

        $manager->flush();
    }
}
