<?php


namespace App\Interfaces\Admin\Phishing;
use Illuminate\Http\Request;

interface PhishingGroupInterface
{
    public function getAll();
    public function store(Request $request);
    public function update($id,Request $request);
    public function trash($group);
    public function restore($id,Request $request);
    public function delete($id);
    public function getArchivedGroups();
    public function PhishingGroupeDatatable(Request $request);
    public function archivedGroupsDatatable(Request $request);
    public function AddUsersTogroup(Request $request);
    public function getUsersForGroup($id);



    // public function getCategoryWebsites($id);

}
