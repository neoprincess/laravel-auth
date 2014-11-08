<?php

namespace ViKon\Auth\models;

use Illuminate\Database\Eloquent\Model;

/**
 * ViKon\Auth\models\UserPasswordReminder
 *
 * @property integer                      $id
 * @property integer                      $user_id
 * @property string                       $token
 * @property \Carbon\Carbon               $created_at
 * @property-read \ViKon\Auth\models\User $user
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Auth\models\UserPasswordReminder whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Auth\models\UserPasswordReminder whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Auth\models\UserPasswordReminder whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Auth\models\UserPasswordReminder whereCreatedAt($value)
 */
class UserPasswordReminder extends Model
{

    /**
     *
     * Disable updated_at and created_at columns
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The database table used by the model (mysql).
     *
     * @var string
     */
    protected $table = 'user_password_reminders';

    /**
     * The database table used by the model (mongodb).
     *
     * @var string
     */
    protected $collection = 'user_password_reminders';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('ViKon\Auth\models\User', 'id', 'user_id');
    }
}
