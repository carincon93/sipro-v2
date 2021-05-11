<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validación del idioma
	|--------------------------------------------------------------------------
	|
        | Las siguientes líneas de idioma contienen los mensajes de error predeterminados utilizados por
        | La clase validadora. Algunas de estas reglas tienen múltiples versiones tales
        | como las reglas de tamaño. Siéntase libre de modificar cada uno de estos mensajes aquí.
	|
	*/


	'accepted'              => 'El campo :attribute debe ser aceptado.',
	'active_url'            => 'El campo :attribute no es una URL válida.',
	'after'                 => 'El campo :attribute debe ser una fecha después de :date.',
	'after_or_equal'        => 'El campo :attribute debe ser una fecha después o igual a :date.',
	'alpha'                 => 'El campo :attribute sólo puede contener letras.',
	'alpha_dash'            => 'El campo :attribute sólo puede contener letras, números y guiones.',
	'alpha_num'             => 'El campo :attribute sólo puede contener letras y números.',
	'array'                 => 'El campo :attribute debe ser un arreglo.',
	'before'                => 'El campo :attribute debe ser una fecha antes de :date.',
	'before_or_equal'       => 'El campo :attribute debe ser una fecha antes o igual a :date.',
	'between'               => [
		'numeric' => 'El campo :attribute debe estar entre :min - :max.',
		'file'    => 'El campo :attribute debe estar entre :min - :max kilobytes.',
		'string'  => 'El campo :attribute debe estar entre :min - :max caracteres.',
		'array'   => 'El campo :attribute debe tener entre :min y :max elementos.',
	],
	'boolean'               => 'El campo :attribute debe ser verdadero o falso.',
	'confirmed'             => 'El campo de confirmación de :attribute no coincide.',
	'date'                  => 'El campo :attribute no es una fecha válida.',
	'date_format' 	        => 'El campo :attribute no corresponde con el formato :format.',
	'different'             => 'Los campos :attribute y :other deben ser diferentes.',
	'digits'                => 'El campo :attribute debe ser de :digits dígitos.',
	'digits_between'        => 'El campo :attribute debe tener entre :min y :max dígitos.',
	'dimensions'            => 'El campo :attribute no tiene una dimensión válida.',
	'distinct'              => 'El campo :attribute tiene un valor duplicado.',
	'email'                 => 'El formato del :attribute es inválido.',
	'exists'                => 'El campo :attribute seleccionado es inválido.',
	'file'                  => 'El campo :attribute debe ser un archivo.',
	'filled'                => 'El campo :attribute es requerido.',
	'gt'                    => [
		'numeric' => 'El campo :attribute debe ser mayor a :value.',
		'file'    => 'El campo :attribute debe ser mayor a :value kilobytes.',
		'string'  => 'El campo :attribute debe ser mayor a :value caracteres.',
		'array'   => 'El campo :attribute puede tener hasta :value elementos.',
	],
	'gte'                   => [
		'numeric' => 'El campo :attribute debe ser mayor o igual a :value.',
		'file'    => 'El campo :attribute debe ser mayor o igual a :value kilobytes.',
		'string'  => 'El campo :attribute debe ser mayor o igual a :value caracteres.',
		'array'   => 'El campo :attribute puede tener :value elementos o más.',
	],
	'image'                 => 'El campo :attribute debe ser una imagen.',
	'in'                    => 'El campo :attribute seleccionado es inválido.',
	'in_array'              => 'El campo :attribute no existe en :other.',
	'integer'               => 'El campo :attribute debe ser un entero.',
	'ip'                    => 'El campo :attribute debe ser una dirección IP válida.',
	'ipv4'                  => 'El campo :attribute debe ser una dirección IPv4 válida.',
	'ipv6'                  => 'El campo :attribute debe ser una dirección IPv6 válida.',
	'json'                  => 'El campo :attribute debe ser una cadena JSON válida.',
	'lt'                   => [
		'numeric' => 'El campo :attribute debe ser menor a :max.',
		'file'    => 'El campo :attribute debe ser menor a :max kilobytes.',
		'string'  => 'El campo :attribute debe ser menor a :max caracteres.',
		'array'   => 'El campo :attribute puede tener hasta :max elementos.',
	],
	'lte'                   => [
		'numeric' => 'El campo :attribute debe ser menor o igual a :max.',
		'file'    => 'El campo :attribute debe ser menor o igual a :max kilobytes.',
		'string'  => 'El campo :attribute debe ser menor o igual a :max caracteres.',
		'array'   => 'El campo :attribute no puede tener más que :max elementos.',
	],
	'max'                   => [
		'numeric' => 'El campo :attribute debe ser menor a :max.',
		'file'    => 'El campo :attribute debe ser menor a :max kilobytes.',
		'string'  => 'El campo :attribute debe ser menor a :max caracteres.',
		'array'   => 'El campo :attribute puede tener hasta :max elementos.',
	],
	'mimes'                 => 'El campo :attribute debe ser un archivo de tipo: :values.',
	'mimetypes'             => 'El campo :attribute debe ser un archivo de tipo: :values.',
	'min'                   => [
		'numeric' => 'El campo :attribute debe tener al menos :min.',
		'file'    => 'El campo :attribute debe tener al menos :min kilobytes.',
		'string'  => 'El campo :attribute debe tener al menos :min caracteres.',
		'array'   => 'El campo :attribute debe tener al menos :min elementos.',
	],
	'not_in'                => 'El campo :attribute seleccionado es invalido.',
	'not_regex'             => 'El formato del campo :attribute es inválido.',
	'numeric'               => 'El campo :attribute debe ser un número.',
	'present'               => 'El campo :attribute debe estar presente.',
	'regex'                 => 'El formato del campo :attribute es inválido.',
	'required'              => 'El campo :attribute es requerido.',
	'required_if'           => 'El campo :attribute es requerido cuando el campo :other es :value.',
	'required_unless'       => 'El campo :attribute es requerido a menos que :other esté presente en :values.',
	'required_with'         => 'El campo :attribute es requerido cuando :values está presente.',
	'required_with_all'     => 'El campo :attribute es requerido cuando :values está presente.',
	'required_without'      => 'El campo :attribute es requerido cuando :values no está presente.',
	'required_without_all'  => 'El campo :attribute es requerido cuando ningún :values está presente.',
	'same'                  => 'El campo :attribute y :other debe coincidir.',
	'size'                  => [
		'numeric' => 'El campo :attribute debe ser :size.',
		'file'    => 'El campo :attribute debe tener :size kilobytes.',
		'string'  => 'El campo :attribute debe tener :size caracteres.',
		'array'   => 'El campo :attribute debe contener :size elementos.',
	],
	'starts_with'           => 'El :attribute debe empezar con uno de los siguientes valores :values',
	'string'                => 'El campo :attribute debe ser una cadena.',
	'timezone'              => 'El campo :attribute debe ser una zona válida.',
	'unique'                => 'El campo :attribute ya ha sido tomado.',
	'uploaded'              => 'El campo :attribute no ha podido ser cargado.',
	'url'                   => 'El formato de :attribute es inválido.',
	'uuid'                  => 'El :attribute debe ser un UUID valido.',

	/*
	|--------------------------------------------------------------------------
	| Validación del idioma personalizado
	|--------------------------------------------------------------------------
	|
	|	Aquí puede especificar mensajes de validación personalizados para atributos utilizando el
	| convención "attribute.rule" para nombrar las líneas. Esto hace que sea rápido
	| especifique una línea de idioma personalizada específica para una regla de atributo dada.
	|
	*/

	'custom' => [
		'attribute-name' => [
			'rule-name'  => 'custom-message',
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Atributos de validación personalizados
	|--------------------------------------------------------------------------
	|
        | Las siguientes líneas de idioma se utilizan para intercambiar los marcadores de posición de atributo.
        | con algo más fácil de leer, como la dirección de correo electrónico.
        | de "email". Esto simplemente nos ayuda a hacer los mensajes un poco más limpios.
	|
	*/

	'attributes' => [
        // Usuarios - Users
        'academic_centre_id'    => 'centro de formación',
        'name'                  => 'nombre',
        'email'                 => 'correo electrónico',
        'document_type'         => 'tipo de documento',
        'document_number'       => 'número de documento',
        'cellphone_number'      => 'número de celular',
        'participation_type'    => 'tipo de participación',
        'is_enabled'            => 'habilitado',
        'role_id'               => 'rol',

        // Centro de formación - Academic centre
        'regional_id'           => 'regional',
		'code'                  => 'código',
		'regional_director_id'  => 'Director(a) Regional',
		'deputy_director_id'  	=> 'Subdirector del Centro de Formación',

        // Programa de formación - Academic program
        'study_mode'            => 'modalidad',

        // Actividad - Activity
        'specific_objective_id'     => 'objetivo específico',
        'description'               => 'descripción',
        'start_date'                => 'fecha de inicio',
        'end_date'                  => 'fecha de cierre',
        'output_id'                 => 'productos',
        'project_sennova_budget_id' => 'rubros de proyecto',

        // Anexos - Annexes
        'programmatic_line_id'  => 'línea programática',

        // Rubro de convocatoria - Call budget
        'sennova_budget_id'     => 'rubro sennova',
        'call_id'               => 'convocatoria',

        // Convocatoria - Call
        'active'                => 'activo',
        'project_start_date'    => 'fecha límite de inicio de proyectos',
        'project_end_date'      => 'fecha límite de cierre de proyectos',

        // Rol SENNOVA de convocatoria - Call sennova role
        'salary'                => 'asingación mensual',
        'qty_months'            => 'cantidad de meses',
        'qty_roles'             => 'cantidad de roles',

        // Impacto - Impact
        'type'                  => 'tipo',

        // Disciplina de subárea de conocimiento - Knowledge subarea discipline
        'knowledge_subarea_id'  => 'subárea de conocimiento',

        // Subárea de conocimiento - Knowledge subarea
        'knowledge_area_id'     => 'área de conocimiento',

        // Estudio de mercado - Market research
        'first_price_quote'         => 'valor del soporte/cotización',
        'first_company_name'        => 'nombre de la compañía',
        'first_price_quote_file'    => 'archivo',
        'second_price_quote'        => 'valor del soporte/cotización',
        'second_company_name'       => 'nombre de la compañía',
        'second_price_quote_file'   => 'archivo',
        'third_price_quote'         => 'valor del soporte/cotización',
        'third_company_name'        => 'nombre de la compañía',
        'third_price_quote_file'    => 'archivo',

        // Subtipología Minciencias - MincienciasSubtypology
        'minciencias_typology_id'   => 'tipología Minciencias',

        // Producto - Output
        'project_result_id'         => 'resultado',
		'trl'                       => 'TRL',

        // Entidad aliada - Partner organization
		'partner_organization_type' => 'tipo de entidad aliada',
		'nit'                       => 'NIT',
		'legal_status'              => 'estado legal',
		'company_type'              => 'tipo de entidad',
		'agreement_description'     => 'descripción del convenio',
		'research_group'            => 'grupo de investigación',
		'gruplac_code'              => 'código GrupLac',
		'gruplac_link'              => 'enlace GrupLac',
		'knowledge_transfer_activities' => 'actividades de transferencia de conocimiento',
		'letter_of_intent'          => 'carta de intención',
		'intellectual_property'     => 'propiedad intelectual',
        'in_kind'                   => 'recursos en especie',
        'in_kind_description'       => 'descripción',
        'funds'                     => 'recursos',
        'funds_description'         => 'descripción',
        'activity_id'               => 'actividades',

        // Tema priorizado - Prioritized topic
        'productive_sector_id'      => 'sector productivo',
		'technical_committee_id'    => 'mesa técnica de servicios tecnológicos',

        // Línea programática - Programmatic line
		'project_category'          => 'categoría del proyecto',

        // Anexo de proyecto - Project annexe
        'annexe_id'                 => 'anexo',
		'file'                      => 'archivo',

        // Estudio de mercado - Market research
        'qty_items'                 => 'cantidad de ítems',
        'fact_sheet'                => 'ficha técnica',

        // Resultado - Project result
		'indicator'                 => 'indicador',
        'means_of_verification'     => 'medios de verificación',

        // Rubro de proyecto - Project sennova budget
        'call_budget_id'            => 'rubro de convocatoria',
		'justification'             => 'justificación',
        'value'                     => 'valor',

        // Rol de proyecto - Project sennova role
        'call_sennova_role_id'      => 'rol de convocatoria',

        // Tipo de proyecto - Project type
		'maximum_value'             => 'valor máximo',

        // Proyecto I+D+i - RDI
        'project_type_id'                           => 'tipo de proyecto',
        'research_line_id'                          => 'línea de investigación',
		'knowledge_subarea_discipline_id'           => 'disciplina de la subárea de conocimiento',
        'strategic_thematic_id'                     => 'temáticas estratégicas SENA',
		'knowledge_network_id'                      => 'red de conocimiento',
        'ciiu_code_id'                              => 'código CIIU',
		'title'                                     => 'título',
		'abstract'                                  => 'resumen ',
		'project_background'                        => 'antecedentes del proyecto',
		'conceptual_framework'                      => 'marco conceptual',
		'project_methodology'                       => 'metodología del proyecto',
		'sustainability_proposal'                   => 'propuesta de sostenibilidad',
		'primary_objective'                         => 'objetivo general',
		'bibliography'                              => 'bibliografía',
		'students'                                  => 'número de aprendices beneficiados',
        'sampling'                                  => 'muestras',
        'sampling_activity'                         => 'actividad que pretende con la especie nativa',
        'sampling_objective'                        => 'finalidad de las actividades a realizar con la especie nativa',
        'cities'                                    => 'nombre de los municipios beneficiados',
        'cities'                                    => 'nombre de los municipios beneficiados',
        'cities_impact'                             => 'descripción del beneficio en los municipios',
        'academic_impact'                           => 'impacto académico',
        'related_with_technological_plan'           => '¿El proyecto se alinea con el plan tecnológico desarrollado por el centro de formación?',
        'related_with_competitiveness_innovation'   => '¿El proyecto se alinea con las Agendas Departamentales de Competitividad e Innovación?',
        'related_with_sector_based_committee'       => '¿El proyecto se alinea con las Mesas Sectoriales?',
        'related_with_techno_academy'               => '¿El proyecto se formuló en conjunto con la tecnoacademia?',
        'sector_based_committee_id'                 => 'mesa sectorial',
        'technological_line_id'                     => 'línea tecnológica',
        'industry_4_justification'                  => 'industria 4.0',
		'orange_economy_justification'              => 'economía naranja',
		'people_disabilities_justification'         => 'Política Institucional para Atención de las Personas con discapacidad',
		'problem_statement'                         => 'planteamiento del problema',
		'problem_justification'                     => 'justificacion',

        // Grupo de investigación - Research group
		'acronym'               => 'acrónimo del grupo de investigación',
		'minciencias_code'      => 'código Minciencias',
		'minciencias_category'  => 'categoría Minciencias',

        // Línea de investigación - Research line
		'research_group_id' => 'grupo de investigación',

        // Análisis de riesgos - Risk analysis
		'level'                 => 'nivel',
		'impact'                => 'impacto',
		'probability'           => 'probabilidad',
		'effects'               => 'efectos',
		'mitigation_measures'   => 'medidas de mitigación',

        // Rubro SENNOVA - SENNOVA budget
        'first_budget_info_id'              => 'nombre de cuenta',
        'second_budget_info_id'             => 'concepto interno SENA',
        'third_budget_info_id'              => 'rubro',
        'budget_usage_id'                   => 'uso presupuestal',
        'requires_third_market_research'    => '¿Requiere de un tercer estudio de mercado?',
        'requires_market_research_batch'    => 'requiere múltiples estudios de mercados',
        'requires_market_research'          => 'requiere de estudio de mercado',
        'can_be_added'                      => 'puede sumar al total del proyecto',
        'message'                           => 'mensaje',
        'max_value'                         => 'valor máximo',
        'true'                              => 'si',

        // Rol SENNOVA - SENNOVA role
        'academic_degree'   => 'nivel educativo',

        // Objetivo específico - Specific objective
        'number'            => 'número',

        // Roles - Role
        'permission_id'     => 'permisos',

		'objectives_tree'   => 'árbol de objetivos',
        'problem_tree'      => 'árbol de problemas',
		'indirect_code'     => 'código indirecto',
		'value_chain'       => 'cadena de valor',
		'password'          => 'contraseña',
	],
];
