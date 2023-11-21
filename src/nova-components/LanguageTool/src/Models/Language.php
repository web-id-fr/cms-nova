<?php

namespace Webid\LanguageTool\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class Language.
 *
 * @property string $flag
 * @property string $name
 */
class Language extends Model
{
    use HasFactory;

    /**
     * Flags key for css class name
     * Why ? Exemple : EN flag is "GB" class name and not "EN".
     *
     * @var array
     */
    public const FLAGS_BY_LOCAL = [
        // Inutile de mettre les langues dont le code pays et le code langue sont les mêmes, ex : fr => fr
        'en' => 'gb',
        'ar' => 'dz',
        'ja' => 'jp',
        'pt-br' => 'br',
        'zh' => 'cn',
    ];

    /**
     * @var string
     */
    protected $table = 'languages_flags';

    protected $fillable = [
        'name',
        'flag',
    ];

    /**
     * @return array|\ArrayAccess|mixed
     */
    public static function flagsByLocal(string $local)
    {
        return Arr::get(static::FLAGS_BY_LOCAL, $local, $local);
    }

    public function save(array $options = []): bool
    {
        if ($this->flag && ! $this->name) {
            $search = null;
            foreach (config('translatable.locales') as $local => $language) {
                if ($local == self::getLocalByFlag($this->flag)) {
                    $search = $language;

                    break;
                }
            }
            $this->name = $search ? $search : null;
        }

        return parent::save($options);
    }

    /**
     * @return array|\ArrayAccess|mixed
     */
    public static function getLocalByFlag(string $flag)
    {
        $LocalsByFlag = array_flip(self::FLAGS_BY_LOCAL);

        return Arr::get($LocalsByFlag, $flag, $flag);
    }
}
