<?php
try {
    // remove media manager type effect
    rex_sql::factory()->setQuery('delete from ' . rex::getTable('media_manager_type_effect') . ' where effect = "optimize"');
} catch (rex_sql_exception $e) {
}
