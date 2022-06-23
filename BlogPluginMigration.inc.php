<?php

/**
 * @file classes/migration/BlogPluginMigration.inc.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2000-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class BlogPluginMigration
 * @brief Describe database table structures.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class BlogPluginMigration extends Migration {
        /**
         * Run the migrations.
         * @return void
         */
        public function up() {
		Capsule::schema()->create('blog_entries', function (Blueprint $table) {
			$table->bigInteger('entry_id')->autoIncrement();
			$table->bigInteger('context_id');
			$table->string('title', 255);
			$table->string('byline', 255);
			$table->longText('content');
			$table->datetime('date_posted');
		});

		Capsule::schema()->create('blog_keywords', function (Blueprint $table) {
			$table->bigInteger('keyword_id')->autoIncrement();
			$table->string('keyword', 255);
		});

		Capsule::schema()->create('blog_entries_keywords', function (Blueprint $table) {
			$table->bigInteger('entry_id');
			$table->bigInteger('keyword_id');
		});

	}
}