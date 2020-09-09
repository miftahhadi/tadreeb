<?php

namespace App\Services\Admin;

use App\Lesson;

class LessonService
{
    public function createLesson($data)
    {
        return auth()->user()->lessons()->create($data);
    }

    public function update($data, Lesson $pelajaran)
    {
        /* $pelajaran->judul = $data['judul'];
        $pelajaran->slug = $data['slug'];
        $pelajaran->deskripsi = $data['deskripsi'];
 */
        return $pelajaran->update([
                    'judul' => $data['judul'],
                    'slug' => $data['slug'],
                    'deskripsi' => $data['deskripsi']
                ]);
    }

    public function destroy(Lesson $pelajaran)
    {
        // Hapus section dan isinya

        // Hapus pelajaran
        return $pelajaran->delete();
    }
}