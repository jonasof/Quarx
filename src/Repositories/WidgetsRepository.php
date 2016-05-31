<?php

namespace Yab\Quarx\Repositories;

use Yab\Quarx\Services\Quarx;
use Yab\Quarx\Models\Widgets;
use Illuminate\Support\Facades\Schema;

class WidgetsRepository
{

    /**
     * Returns all Widgets
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Widgets::orderBy('created_at', 'desc')->all();
    }

    public function paginated()
    {
        return Widgets::orderBy('created_at', 'desc')->paginate(25);
    }

    public function search($input)
    {
        $query = Widgets::orderBy('created_at', 'desc');

        $columns = Schema::getColumnListing('widgets');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$input['term'].'%');
        };

        return [$query, $input['term'], $query->paginate(25)->render()];
    }

    /**
     * Stores Widgets into database
     *
     * @param array $input
     *
     * @return Widgets
     */
    public function store($input)
    {
        return Widgets::create($input);
    }

    /**
     * Find Widgets by given id
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Widgets
     */
    public function findWidgetsById($id)
    {
        return Widgets::find($id);
    }


    /**
     * Find Widgets by given slug
     *
     * @param int $slug
     *
     * @return \Illuminate\Support\Collection|null|static|Widgets
     */
    public static function getWidgetBySLUG($slug)
    {
        return Widgets::where('slug', $slug)->first();
    }

    /**
     * Updates Widgets into database
     *
     * @param Widgets $widgets
     * @param array $input
     *
     * @return Widgets
     */
    public function update($widgets, $input)
    {
        $widgets->fill($input);
        $widgets->save();

        return $widgets;
    }
}