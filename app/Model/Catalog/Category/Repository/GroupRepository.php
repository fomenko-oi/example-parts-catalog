<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\Repository;

use App\Entity\Catalog\Model\Mark;
use App\Entity\Catalog\Model\Mark\Group;

class GroupRepository
{
    public function getById(int $id): Group
    {
        return Group::where('id', $id)->firstOrFail();
    }

    public function getByName(string $name): Group
    {
        return Group::where('name', $name)->orWhere('name_ru', $name)->firstOrFail();
    }

    public function findByName(string $name): ?Group
    {
        return Group::where('name', $name)->orWhere('name_ru', $name)->first();
    }

    public function create(Mark $mark, string $name, ?string $nameRu = null, ?string $description = null, ?string $subject = null, ?string $image = null): Group
    {
        /** @var Group $group */
        $group = $mark->groups()->create([
            'name' => $name,
            'name_ru' => $nameRu,
            'description' => $description,
            'subject' => $subject,
            'image' => $image,
        ]);

        return $group;
    }

    public function update(Group $group, string $name, ?string $nameRu, ?string $description, ?string $subject, ?string $image): Group
    {
        /** @var Group $group */
        $group->update([
            'name' => $name,
            'name_ru' => $nameRu,
            'description' => $description,
            'subject' => $subject,
            'image' => $image,
        ]);

        return $group;
    }
}
