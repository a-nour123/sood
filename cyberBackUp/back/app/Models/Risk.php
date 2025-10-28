<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Events\RiskCreated;
use App\Models\Asset;

class Risk extends Model
{
    use HasFactory;
    use Auditable;

    public $guarded = [];

    public function Risk()
    {
        return $this->hasMany(Risk::class, 'risk_id');
    }


    /**
     * Get all of the risk catalogs for the risk.
     */
    public function riskCatalogs()
    {
        $riskCatalogs = DB::table('risk_catalogs')->whereIn('id', explode(',', $this->risk_catalog_mapping))->select('id', 'name')->get()->toArray();
        foreach ($riskCatalogs as $key => $riskCatalog)
            $riskCatalogs[$key] =  json_decode(json_encode($riskCatalog), true);
        return $riskCatalogs;
    }

    /**
     * Get all of the threat catalogs for the risk.
     */
    public function threatCatalog()
    {
        $threatCatalogs =  DB::table('threat_catalogs')->whereIn('id', explode(',', $this->threat_catalog_mapping))->select('id', 'name')->get()->toArray();
        foreach ($threatCatalogs as $key => $threatCatalog)
            $threatCatalogs[$key] =  json_decode(json_encode($threatCatalog), true);
        return $threatCatalogs;
    }
    /**
     * Get all of the tags for the risk.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get risk score
     */
    public function riskScoring()
    {
        return $this->hasOne(RiskScoring::class, 'id');
    }

    /**
     * Get locations
     */
    public function locations()
    {
        return $this->hasMany(RiskToLocation::class);
    }

    /**
     * Get teams
     */
    public function teams()
    {
        return $this->hasMany(RiskToTeam::class);
    }

    /**
     * Get teams
     */
    public function teamsForRisk()
    {
        return $this->belongsToMany(Team::class, 'risk_to_teams');
    }

    /**
     * Get technologies
     */
    public function technologies()
    {
        return $this->hasMany(RiskToTechnology::class);
    }

    /**
     * Get additionalStakeholders
     */
    public function additionalStakeholders()
    {
        return $this->hasMany(RiskToAdditionalStakeholder::class);
    }

    /**
     * Get category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get control
     */
    public function control()
    {
        return $this->belongsTo(FrameworkControl::class);
    }

    /**
     * Get framework
     */
    public function framework()
    {
        return $this->belongsTo(Framework::class, 'regulation');
    }


    /**
     * Get risksToAsset
     */
    public function risksToAsset()
    {
        return $this->hasMany(RisksToAsset::class);
    }

    /**
     * Get risksToAssetGroup
     */
    public function risksToAssetGroup()
    {
        return $this->hasMany(RisksToAssetGroup::class);
    }

    /**
     * Get submitted_by
     */
    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    /**
     * Get source
     */
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

    /**
     * Get owner
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get manager
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get files
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }
    /**
     * Get the Closure associated with the risk.
     */
    public function closure()
    {
        return $this->hasOne(Closure::class);
    }
    /**
     * Get the mitigation associated with the risk.
     */
    public function mitigation()
    {
        return $this->belongsTo(Mitigation::class);
    }
    /**
     * Get the project associated with the risk.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    /**
     * Get the project associated with the risk.
     */
    public function locationsOfRisk()
    {
        return $this->belongsToMany(Location::class, 'risk_to_locations');
    }
    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'risks_to_assets');
    }

    /**
     * Get the technologies associated with the risk.
     */
    public function technologiesOfRisk()
    {
        return $this->belongsToMany(Technology::class, 'risk_to_technologies');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function threatCatalogs()
    {
        // Assuming 'threat_catalog_mapping' is a comma-separated list of threat catalog IDs
        $threatCatalogIds = explode(',', $this->threat_catalog_mapping);

        return ThreatCatalog::whereIn('id', $threatCatalogIds);
    }
    public function threatCatalogsMapiings()
    {
        // Assuming 'threat_catalog_mapping' is a comma-separated list of threat catalog IDs
        $threatCatalogMappingIds = explode(',', $this->risk_catalog_mapping);

        return DB::table('risk_catalogs')->whereIn('id', $threatCatalogMappingIds);
    }
    
}
