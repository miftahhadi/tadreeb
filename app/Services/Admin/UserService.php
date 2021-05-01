<?php

namespace App\Services\Admin;

use App\Models\Classroom;
use App\Models\CsvUserData;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserService 
{
    public $userField = [
        'nama', 'email', 'username', 'password', 'role_id', 'gender', 'tanggal_lahir', 'kelas_id', 'whatsapp', 'telegram'
    ];

    public function parseCsv($file)
    {
        $data = array_map('str_getcsv', file($file->path()));

        $toBeSaved = array_slice($data, 1);

        $csvDataFile = CsvUserData::create([
            'csv_filename' => $file->getClientOriginalName(),
            'csv_data' => json_encode($toBeSaved)
        ]);

        return $csvDataFile;
    }
    
    public function processCsv($id)
    {
        $data = CsvUserData::find($id); 

        $csvData = json_decode($data->csv_data, true);

        $errors = [];

        $imported = 0;

        $updated = 0;

        foreach ($csvData as $key => $row) {
            $user = User::where('username', $row[2])->first();

            if ($user !== null) {

                try {
                    $user->classrooms()->attach($row[7]);
                    $updated++; 
                } catch (\Throwable $e) {
                    $error = 'Error untuk baris ' . $key . ': ' . report($e);

                    array_push($errors, $error);
                }
            
            } else {

                try {
                    $user = User::create([
                        'name' => $row[0],
                        'email' => $row[1],
                        'username' => $row[2],
                        'password' => Hash::make($row[3]),
                    ]);

                    $user->profile()->create([
                        'gender' => $row[5] ?? null,
                        'tanggal_lahir' => ($row[6] != '') 
                                                ? Carbon::parse($row[6])->format('Y-m-d')
                                                : null,
                        'whatsapp' => $row[8] ?? null,
                        'telegram' => $row[9] ?? null
                    ]);
    
                    if ($row[4]) {
                        $user->assignRole($row[4]);
                    } else {
                        $user->assignRole(4);
                    }
    
                    if (Classroom::find($row[7])) {
                        $user->classrooms()->attach($row[7]);
                    }

                    $imported++;
                    
                } catch (Throwable $e) {
                    $error = 'Error untuk baris ' . $key . ': ' . report($e);

                    array_push($errors, $error);
                }

            }
        }

        return [
            'imported' => $imported,
            'updated' => $updated,
            'errors' => $errors,
        ];

    }
}