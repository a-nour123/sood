<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
   use HasFactory;
   use Auditable;
   public $guarded = [];
   public $timestamps = false;


   public function documentTypes()
   {
      return $this->hasMany("App\Models\DocumentTypes", "id", "document_type");
   }

   /**
    * Get notes for this document.
    */

   public function notes()
   {
      return $this->hasMany(DocumentNote::class)->with('user:id,name');
   }

   /**
    * Get file for this document.
    */
   public function file()
   {
      return $this->belongsTo(File::class, 'file_id');
   }

   public function note_files()
   {
      return $this->hasMany(DocumentNoteFile::class)->with('user:id,name');
   }

   public function Frameworks()
   {
      return $this->hasMany("App\Models\Framework", "id", "framework_ids");
   }

   public function frameworkControls()
   {
      return $this->hasMany("App\Models\FrameworkControl", "id", "control_ids");
   }

   public function owners()
   {
      return $this->hasMany("App\Models\ControlOwner", "id", "document_owner");
   }

   public function owner()
   {
      return $this->belongsTo(User::class, "document_owner");
   }

      public function reviewer()
   {
      return $this->belongsTo(User::class, "document_reviewer");
   }
   

   public function documentStatus()
   {
      return $this->belongsTo(DocumentStatus::class, 'document_status');
   }

   public function status()
   {
      return $this->hasMany("App\Models\DocumentStatus", "id", "document_status");
   }

   public function created_by_user()
   {
      return $this->belongsTo(User::class, 'created_by');
   }

   public function owned_by_user()
   {
      return $this->belongsTo(User::class, 'document_owner');
   }
   public function policies()
   {
      return $this->belongsToMany(CenterPolicy::class, 'document_policies', 'document_id', 'policy_id');
   }
   public function auditDocumentTotalStatuses()
   {
      return $this->hasMany(AuditDocumentTotalStatus::class);
   }
   public function hasRelations()
   {
       $relations = [
           'policies' => $this->policies()->exists(),
          
       ];
       // Filter out empty relations
       return array_filter($relations, fn($count) => $count > 0);
      }
}