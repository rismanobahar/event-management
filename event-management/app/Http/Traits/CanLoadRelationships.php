<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanLoadRelationships{
    public function loadRelationships(
        Model|QueryBuilder|EloquentBuilder|HasMany $for,
        ?array $relations = null // Allow passing an array of relations to be loaded, or use the class property if not provided
    ): Model|QueryBuilder|EloquentBuilder|HasMany {
        $relations = $relations ?? $this->relations ?? []; // Get the relations from the class property or use an empty array if not set

        foreach ($relations as $relation) {
            $for->when(
                $this->shouldIncludeRelation($relation), // Check if the relationship should be included
                fn($q) => $for instanceof Model ? $for->load($relation) : $q->with($relation) // Eager load the relationship. $q->load($relation) is changed to $for->load($relation) to load the relationship on the model instance 
            );
        }

        return $for; // Return the modified query builder or model instance
    }

    protected function shouldIncludeRelation(string $relation): bool
    {
        $include = request()->query('include'); // Get the 'include' query parameter from the request

        if (!$include) {
            return false; // If the 'include' parameter is not present, return false
        }

        // $relations = explode(',', $include); // Split the 'include' parameter by commas
        $relations = array_map('trim', explode(',', $include)); // Split the 'include' parameter by commas and trim whitespace if the endpoint is a string with spaces

        // dd($include); // Debugging line to check the include parameter
        // dd($relations); // Debugging line to check the relations and turn it into an array
       
        /* after there is a trim function to remove the spaces, we can
           use the following line to check if the relation is in the array of
           relations, not using dd anymore */
        
        return in_array($relation, $relations); // Check if the specified relation is in the array of relations
    }
}