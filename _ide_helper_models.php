<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $requirements
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $website
 * @property \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Website> $websites
 * @property-read int|null $websites_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement forWebsite(?int $websiteId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement withAllTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement withAnyTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Achievement withoutTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 */
	class Achievement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $website
 * @property \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Website> $websites
 * @property-read int|null $websites_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Battle forWebsite(?int $websiteId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Battle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Battle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Battle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Battle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Battle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Battle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Battle withAllTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Battle withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Battle withAnyTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Battle withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Battle withoutTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 */
	class Battle extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $status
 * @property int|null $player_limit
 * @property string|null $remark
 * @property string|null $ended_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GameLog> $game_logs
 * @property-read int|null $game_logs_count
 * @property-read mixed $website
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Item> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Map|null $map
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Monster> $monsters
 * @property-read int|null $monsters_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Player> $players
 * @property-read int|null $players_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Save> $saves
 * @property-read int|null $saves_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Wncms\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Website> $websites
 * @property-read int|null $websites_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game forWebsite(?int $websiteId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game wherePlayerLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game withAllTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game withAnyTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game withoutTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 */
	class Game extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $game_id
 * @property int|null $player_id
 * @property int|null $game_log_template_id
 * @property array<array-key, mixed> $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game $game
 * @property-read \App\Models\GameLogTemplate|null $game_log_template
 * @property-read mixed $website
 * @property-read \App\Models\Player|null $player
 * @property \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Website> $websites
 * @property-read int|null $websites_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog forWebsite(?int $websiteId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereGameLogTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog withAllTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog withAnyTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog withoutTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 */
	class GameLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $type
 * @property string $key
 * @property string $content
 * @property string $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $website
 * @property \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Translatable\Models\Translation> $translations
 * @property-read int|null $translations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Website> $websites
 * @property-read int|null $websites_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate forWebsite(?int $websiteId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate withAllTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate withAnyTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLogTemplate withoutTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 */
	class GameLogTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $item_template_id
 * @property int|null $player_id
 * @property int|null $game_id
 * @property int|null $x
 * @property int|null $y
 * @property int|null $z
 * @property int|null $times
 * @property array<array-key, mixed>|null $value
 * @property int $is_equipped
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $website
 * @property-read \App\Models\ItemTemplate|null $item_template
 * @property-read \App\Models\Player|null $player
 * @property \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Website> $websites
 * @property-read int|null $websites_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item forWebsite(?int $websiteId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item location($x, $y)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereIsEquipped($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereItemTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereY($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereZ($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item withAllTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item withAnyTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item withoutTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 */
	class Item extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $status
 * @property string $slug
 * @property string $type
 * @property string $name
 * @property string|null $description
 * @property array<array-key, mixed>|null $value
 * @property int $is_stackable
 * @property string $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $thumbnail
 * @property-read mixed $website
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Item> $items
 * @property-read int|null $items_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Translatable\Models\Translation> $translations
 * @property-read int|null $translations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Website> $websites
 * @property-read int|null $websites_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate forWebsite(?int $websiteId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate whereIsStackable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate withAllTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate withAnyTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemTemplate withoutTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 */
	class ItemTemplate extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $game_id
 * @property string $type
 * @property int|null $min_x
 * @property int|null $min_y
 * @property int|null $min_z
 * @property int|null $max_x
 * @property int|null $max_y
 * @property int|null $max_z
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game $game
 * @property-read mixed $website
 * @property \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Website> $websites
 * @property-read int|null $websites_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map forWebsite(?int $websiteId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map whereMaxX($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map whereMaxY($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map whereMaxZ($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map whereMinX($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map whereMinY($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map whereMinZ($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map withAllTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map withAnyTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Map withoutTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 */
	class Map extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $monster_template_id
 * @property int|null $game_id
 * @property int|null $x
 * @property int|null $y
 * @property int|null $z
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $website
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Monster> $monsters
 * @property-read int|null $monsters_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Website> $websites
 * @property-read int|null $websites_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster forWebsite(?int $websiteId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster whereMonsterTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster whereY($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster whereZ($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster withAllTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster withAnyTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monster withoutTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 */
	class Monster extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $type
 * @property string|null $value
 * @property string $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $website
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Monster> $monsters
 * @property-read int|null $monsters_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Website> $websites
 * @property-read int|null $websites_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate forWebsite(?int $websiteId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate withAllTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate withAnyTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonsterTemplate withoutTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 */
	class MonsterTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $game_id
 * @property int|null $user_id
 * @property string $type
 * @property string $status
 * @property string|null $name
 * @property int $level
 * @property int $exp
 * @property int|null $exp_next
 * @property int|null $hp
 * @property int|null $max_hp
 * @property int|null $mp
 * @property int|null $max_mp
 * @property int|null $vit
 * @property int|null $str
 * @property int|null $int
 * @property int|null $dex
 * @property int|null $luc
 * @property int|null $location_x
 * @property int|null $location_y
 * @property int|null $location_z
 * @property int|null $previous_location_x
 * @property int|null $previous_location_y
 * @property int|null $previous_location_z
 * @property int $kill
 * @property \Illuminate\Support\Carbon|null $died_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PlayerAction> $actions
 * @property-read int|null $actions_count
 * @property-read \App\Models\Game $game
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GameLog> $game_logs
 * @property-read int|null $game_logs_count
 * @property-read int $final_atk
 * @property-read int $final_crit
 * @property-read int $final_def
 * @property-read int $final_dex
 * @property-read int $final_int
 * @property-read int $final_luc
 * @property-read int $final_max_hp
 * @property-read int $final_max_mp
 * @property-read int $final_str
 * @property-read int $final_vit
 * @property-read mixed $thumbnail
 * @property-read mixed $website
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Item> $items
 * @property-read int|null $items_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Wncms\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Website> $websites
 * @property-read int|null $websites_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player forWebsite(?int $websiteId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player location($x, $y)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereDex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereDiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereExp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereExpNext($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereInt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereKill($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereLocationX($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereLocationY($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereLocationZ($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereLuc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereMaxHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereMaxMp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereMp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player wherePreviousLocationX($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player wherePreviousLocationY($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player wherePreviousLocationZ($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereStr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereVit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player withAllTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player withAnyTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player withoutTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 */
	class Player extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $player_id
 * @property string $type
 * @property string $status
 * @property array<array-key, mixed>|null $options
 * @property string|null $decision
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $website
 * @property-read \App\Models\Player $player
 * @property \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Website> $websites
 * @property-read int|null $websites_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction forWebsite(?int $websiteId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction whereDecision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction withAllTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction withAnyTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerAction withoutTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 */
	class PlayerAction extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $game_id
 * @property string $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game $game
 * @property-read mixed $website
 * @property \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wncms\Models\Website> $websites
 * @property-read int|null $websites_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Save forWebsite(?int $websiteId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Save newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Save newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Save query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Save whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Save whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Save whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Save whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Save whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Save withAllTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Save withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Save withAnyTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Save withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Save withoutTags(\ArrayAccess|\Wncms\Tags\Tag|array|string $tags, ?string $type = null)
 */
	class Save extends \Eloquent {}
}

