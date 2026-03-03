<?php

namespace Database\Seeders\Classes;

use App\Enums\AbilitySlug;
use App\Enums\ActionType;
use App\Enums\SkillSlug;
use App\Enums\StatSlug;
use App\Models\Ability;
use App\Models\CharacterClass;
use App\Models\ClassAbility;
use App\Models\ClassBonus;
use App\Models\Skill;
use App\Models\Stat;
use Illuminate\Database\Seeder;

class ChefSeeder extends Seeder
{
    public function run(): void
    {
        $chef = CharacterClass::firstOrCreate(
            ['name' => 'Chef'],
            ['description' => 'Bon ben, pas de gaspillage! Si la guérison des os prend beaucoup de temps, la guérison de l\'âme est une affaire personnelle. Après tout, on ne peut pas se battre le ventre vide. (While bone healing takes a long time, healing the soul is a personal matter. After all, you can\'t fight on an empty stomach.)'],
        );

        // Stat bonuses: +1 AC, +2 HP
        $statBonuses = [
            [StatSlug::ArmorClass, 1],
            [StatSlug::HitPoints,  2],
        ];

        foreach ($statBonuses as [$slug, $value]) {
            $stat = Stat::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $chef->id, 'modifiable_type' => $stat->getMorphClass(), 'modifiable_id' => $stat->id],
                ['value' => $value],
            );
        }

        // Ability bonuses: +2 Charisma, +1 Constitution
        $abilityBonuses = [
            [AbilitySlug::Charisma,     2],
            [AbilitySlug::Constitution, 1],
        ];

        foreach ($abilityBonuses as [$slug, $value]) {
            $ability = Ability::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $chef->id, 'modifiable_type' => $ability->getMorphClass(), 'modifiable_id' => $ability->id],
                ['value' => $value],
            );
        }

        // Skill bonuses: +3 Performance, +2 Medicine
        $skillBonuses = [
            [SkillSlug::Performance, 3],
            [SkillSlug::Medicine,    2],
        ];

        foreach ($skillBonuses as [$slug, $value]) {
            $skill = Skill::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $chef->id, 'modifiable_type' => $skill->getMorphClass(), 'modifiable_id' => $skill->id],
                ['value' => $value],
            );
        }

        // Special abilities
        $abilities = [
            [
                'name'        => 'Hearty Meal',
                'description' => 'Vous êtes un excellent chef cuisinier! (You are an excellent Chef!) Your food is extremely nourishing and can speed up the recovery process of an ill or injured character by one day, or remove a status or potion effect.',
                'action_type' => ActionType::Passive,
            ],
            [
                'name'        => 'Julienne',
                'description' => 'Vous maniez vos couteaux avec une dextérité hors pair. (You handle your knives with exceptional skill!) Upon hitting your opponent, you may use your bonus action to lower your enemy\'s AC by one for two turns.',
                'action_type' => ActionType::BonusAction,
            ],
            [
                'name'        => 'Thyme',
                'description' => 'Un bon chef a besoin d\'un assistant. (A good chef needs an assistant.) Add a +2 to an ally\'s skill check.',
                'action_type' => ActionType::Reaction,
            ],
            [
                'name'        => 'Spicy',
                'description' => 'Vous ne partez jamais sans vos précieuses épices. (You never leave without your precious spices.) Toss some spice in their eyes, roll an attack roll with your performance, with your opponent losing vision until they take an action to clear their vision.',
                'action_type' => ActionType::OncePerCombat,
            ],
        ];

        foreach ($abilities as $ability) {
            ClassAbility::firstOrCreate(
                ['class_id' => $chef->id, 'name' => $ability['name']],
                ['description' => $ability['description'], 'action_type' => $ability['action_type']],
            );
        }
    }
}
