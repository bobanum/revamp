<?php

return [
	// Will create that folder in the root of your project
	'folder_name' => '_concepts',
	// If true, will remove the concept's name from the file name. Making 'Table/Controller.php' instead to 'Table/TableController.php'
	'shorten_names' => true,
	// All the sources of files for one concept
	'sources' => [
		'Model',
        'Controller',
        'Migration',
        'Seeder',
        'Factory',
        'Policy',
        'Request',
        'View',
        'Route',
	],
	// List of sources to ignore
	'excluded_sources' => [
		'Route',
	],
	// List of concepts to ignore
	'excluded_concepts' => [
		'User',
	],
];