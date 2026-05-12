<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Créer la table pivot ───────────────────────────────────
        Schema::create('medicament_pharmacie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicament_id')->constrained()->onDelete('cascade');
            $table->foreignId('pharmacie_id')->constrained()->onDelete('cascade');
            $table->integer('stock')->default(0);
            $table->decimal('prix', 10, 2)->default(0);
            $table->timestamps();
            $table->unique(['medicament_id', 'pharmacie_id']);
        });

        // ── 2. Migrer les données existantes ─────────────────────────
        // Grouper par nom : ne garder qu'un seul enregistrement par médicament
        // et créer une entrée pivot pour chaque (medicament, pharmacie)
        $nomToId = [];

        DB::table('medicaments')->orderBy('id')->each(function ($med) use (&$nomToId) {
            if (!array_key_exists($med->nom, $nomToId)) {
                // Premier exemplaire : c'est le canonique
                $nomToId[$med->nom] = $med->id;
            }

            $canonicalId = $nomToId[$med->nom];

            // Créer l'entrée pivot si la pharmacie est renseignée
            if ($med->pharmacie_id) {
                DB::table('medicament_pharmacie')->updateOrInsert(
                    ['medicament_id' => $canonicalId, 'pharmacie_id' => $med->pharmacie_id],
                    ['stock' => $med->stock ?? 0, 'prix' => $med->prix ?? 0,
                     'created_at' => now(), 'updated_at' => now()]
                );
            }

            // Supprimer les doublons (garder uniquement le canonique)
            if ($canonicalId !== $med->id) {
                DB::table('medicaments')->where('id', $med->id)->delete();
            }
        });

        // ── 3. Modifier la table medicaments ─────────────────────────
        // Étape 3a : supprimer les FK et colonnes inutiles
        Schema::table('medicaments', function (Blueprint $table) {
            $table->dropForeign(['pharmacie_id']);
            $table->dropForeign(['categorie_id']);
            $table->dropColumn(['pharmacie_id', 'stock', 'prix']);
        });

        // Étape 3b : rendre categorie_id nullable + contrainte unique sur nom
        Schema::table('medicaments', function (Blueprint $table) {
            $table->unsignedBigInteger('categorie_id')->nullable()->change();
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('set null');
            $table->unique('nom');
        });
    }

    public function down(): void
    {
        // Annuler dans l'ordre inverse
        Schema::table('medicaments', function (Blueprint $table) {
            $table->dropUnique(['nom']);
            $table->dropForeign(['categorie_id']);
        });

        Schema::table('medicaments', function (Blueprint $table) {
            $table->unsignedBigInteger('categorie_id')->nullable(false)->change();
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('pharmacie_id')->constrained()->cascadeOnDelete();
            $table->integer('stock')->default(0);
            $table->decimal('prix', 10, 2)->default(0);
        });

        Schema::dropIfExists('medicament_pharmacie');
    }
};
