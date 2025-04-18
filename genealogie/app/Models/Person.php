<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Person extends Model
{
    use HasFactory;
    protected $table = 'people';

    protected $fillable = [
        'created_by',
        'first_name',
        'last_name',
        'birth_name',
        'middle_names',
        'date_of_birth',
    ];


    // Enfants : personnes dont celle-ci est le parent
    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'relationships', 'parent_id', 'child_id');
    }

    //Parents : personnes dont celle-ci est l’enfant
    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'relationships', 'child_id', 'parent_id');
    }

    //Créateur : l'utilisateur qui a créé cette personne
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function getDegreeWith($target_id)
    {
        if ($this->id == $target_id) {
            return 0;
        }

        $max_depth = 25;

        // Charger toutes les relations bidirectionnelles en une seule requête
        $rows = DB::select("
            SELECT parent_id, child_id FROM relationships
        ");

        // Construire le graphe
        $graph = [];

        foreach ($rows as $row) {
            $graph[$row->parent_id][] = $row->child_id;
            $graph[$row->child_id][] = $row->parent_id;
        }

        // Initialisation de la file (BFS)
        $queue = [[$this->id, 0]];
        $visited = [];

        while (!empty($queue)) {
            [$current, $depth] = array_shift($queue);

            if ($depth > $max_depth) {
                return false;
            }

            if (isset($visited[$current])) {
                continue;
            }

            $visited[$current] = true;

            if (!isset($graph[$current])) {
                continue;
            }

            foreach ($graph[$current] as $related_id) {
                if ($related_id == $target_id) {
                    return $depth + 1;
                }

                $queue[] = [$related_id, $depth + 1];
            }
        }

        return false;
    }

}
