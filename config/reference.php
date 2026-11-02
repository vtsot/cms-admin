<?php

// This file is auto-generated and is for apps only. Bundles SHOULD NOT rely on its content.

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Config\Loader\ParamConfigurator as Param;

/**
 * This class provides array-shapes for configuring the services and bundles of an application.
 *
 * Services declared with the config() method below are autowired and autoconfigured by default.
 *
 * This is for apps only. Bundles SHOULD NOT use it.
 *
 * Example:
 *
 *     ```php
 *     // config/services.php
 *     namespace Symfony\Component\DependencyInjection\Loader\Configurator;
 *
 *     return App::config([
 *         'services' => [
 *             'App\\' => [
 *                 'resource' => '../src/',
 *             ],
 *         ],
 *     ]);
 *     ```
 *
 * @psalm-type ImportsConfig = list<string|array{
 *     resource: string,
 *     type?: string|null,
 *     ignore_errors?: bool|'not_found',
 * }>
 * @psalm-type ParametersConfig = array<string, scalar|\UnitEnum|array<scalar|\UnitEnum|array<mixed>|Param|null>|Param|null>
 * @psalm-type ArgumentsType = list<mixed>|array<string, mixed>
 * @psalm-type CallType = array<string, ArgumentsType>|array{0:string, 1?:ArgumentsType, 2?:bool}|array{method:string, arguments?:ArgumentsType, returns_clone?:bool}
 * @psalm-type TagsType = list<string|array<string, array<string, mixed>>> // arrays inside the list must have only one element, with the tag name as the key
 * @psalm-type CallbackType = string|array{0:string|ReferenceConfigurator,1:string}|\Closure|ReferenceConfigurator|ExpressionConfigurator
 * @psalm-type DeprecationType = array{package: string, version: string, message?: string}
 * @psalm-type DefaultsType = array{
 *     public?: bool,
 *     tags?: TagsType,
 *     resource_tags?: TagsType,
 *     autowire?: bool,
 *     autoconfigure?: bool,
 *     bind?: array<string, mixed>,
 * }
 * @psalm-type InstanceofType = array{
 *     shared?: bool,
 *     lazy?: bool|string,
 *     public?: bool,
 *     properties?: array<string, mixed>,
 *     configurator?: CallbackType,
 *     calls?: list<CallType>,
 *     tags?: TagsType,
 *     resource_tags?: TagsType,
 *     autowire?: bool,
 *     bind?: array<string, mixed>,
 *     constructor?: string,
 * }
 * @psalm-type DefinitionType = array{
 *     class?: string,
 *     file?: string,
 *     parent?: string,
 *     shared?: bool,
 *     synthetic?: bool,
 *     lazy?: bool|string,
 *     public?: bool,
 *     abstract?: bool,
 *     deprecated?: DeprecationType,
 *     factory?: CallbackType,
 *     configurator?: CallbackType,
 *     arguments?: ArgumentsType,
 *     properties?: array<string, mixed>,
 *     calls?: list<CallType>,
 *     tags?: TagsType,
 *     resource_tags?: TagsType,
 *     decorates?: string,
 *     decorates_tag?: string,
 *     decoration_inner_name?: string,
 *     decoration_priority?: int,
 *     decoration_on_invalid?: 'exception'|'ignore'|null,
 *     autowire?: bool,
 *     autoconfigure?: bool,
 *     bind?: array<string, mixed>,
 *     constructor?: string,
 *     from_callable?: CallbackType,
 * }
 * @psalm-type AliasType = string|array{
 *     alias: string,
 *     public?: bool,
 *     deprecated?: DeprecationType,
 * }
 * @psalm-type PrototypeType = array{
 *     resource: string,
 *     namespace?: string,
 *     exclude?: string|list<string>,
 *     parent?: string,
 *     shared?: bool,
 *     lazy?: bool|string,
 *     public?: bool,
 *     abstract?: bool,
 *     deprecated?: DeprecationType,
 *     factory?: CallbackType,
 *     arguments?: ArgumentsType,
 *     properties?: array<string, mixed>,
 *     configurator?: CallbackType,
 *     calls?: list<CallType>,
 *     tags?: TagsType,
 *     resource_tags?: TagsType,
 *     autowire?: bool,
 *     autoconfigure?: bool,
 *     bind?: array<string, mixed>,
 *     constructor?: string,
 * }
 * @psalm-type StackType = array{
 *     stack: list<DefinitionType|AliasType|PrototypeType|array<class-string, ArgumentsType|null>>,
 *     public?: bool,
 *     deprecated?: DeprecationType,
 *     decorates?: string,
 *     decorates_tag?: string,
 *     decoration_inner_name?: string,
 *     decoration_priority?: int,
 *     decoration_on_invalid?: 'exception'|'ignore'|null,
 * }
 * @psalm-type ServicesConfig = array{
 *     _defaults?: DefaultsType,
 *     _instanceof?: array<class-string, InstanceofType>,
 *     ...<string, DefinitionType|AliasType|PrototypeType|StackType|ArgumentsType|null>
 * }
 * @psalm-type ExtensionType = array<string, mixed>
 * @psalm-type FrameworkConfig = array{
 *     secret?: scalar|Param|null,
 *     http_method_override?: bool|Param, // Set true to enable support for the '_method' request parameter to determine the intended HTTP method on POST requests. // Default: false
 *     allowed_http_method_override?: null|list<string|Param>,
 *     trust_x_sendfile_type_header?: scalar|Param|null, // Set true to enable support for xsendfile in binary file responses. // Default: "%env(bool:default::SYMFONY_TRUST_X_SENDFILE_TYPE_HEADER)%"
 *     ide?: scalar|Param|null, // Default: "%env(default::SYMFONY_IDE)%"
 *     test?: bool|Param,
 *     default_locale?: scalar|Param|null, // Default: "en"
 *     set_locale_from_accept_language?: bool|Param, // Whether to use the Accept-Language HTTP header to set the Request locale (only when the "_locale" request attribute is not passed). // Default: false
 *     set_content_language_from_locale?: bool|Param, // Whether to set the Content-Language HTTP header on the Response using the Request locale. // Default: false
 *     enabled_locales?: list<scalar|Param|null>,
 *     trusted_hosts?: Param|string|list<scalar|Param|null>,
 *     trusted_proxies?: mixed, // Default: ["%env(default::SYMFONY_TRUSTED_PROXIES)%"]
 *     trusted_headers?: Param|string|list<scalar|Param|null>,
 *     error_controller?: scalar|Param|null, // Default: "error_controller"
 *     handle_all_throwables?: bool|Param, // HttpKernel will handle all kinds of \Throwable. // Default: true
 *     csrf_protection?: bool|array{
 *         enabled?: scalar|Param|null, // Default: null
 *         stateless_token_ids?: list<scalar|Param|null>,
 *         check_header?: scalar|Param|null, // Whether to check the CSRF token in a header in addition to a cookie when using stateless protection. // Default: false
 *         cookie_name?: scalar|Param|null, // The name of the cookie to use when using stateless protection. // Default: "csrf-token"
 *     },
 *     form?: bool|array{ // Form configuration
 *         enabled?: bool|Param, // Default: true
 *         csrf_protection?: bool|array{
 *             enabled?: scalar|Param|null, // Default: null
 *             token_id?: scalar|Param|null, // Default: null
 *             field_name?: scalar|Param|null, // Default: "_token"
 *             field_attr?: array<string, scalar|Param|null>,
 *         },
 *     },
 *     http_cache?: bool|array{ // HTTP cache configuration
 *         enabled?: bool|Param, // Default: false
 *         debug?: bool|Param, // Default: "%kernel.debug%"
 *         trace_level?: "none"|"short"|"full"|Param,
 *         trace_header?: scalar|Param|null,
 *         default_ttl?: int|Param,
 *         private_headers?: list<scalar|Param|null>,
 *         skip_response_headers?: list<scalar|Param|null>,
 *         allow_reload?: bool|Param,
 *         allow_revalidate?: bool|Param,
 *         stale_while_revalidate?: int|Param,
 *         stale_if_error?: int|Param,
 *         terminate_on_cache_hit?: bool|Param, // Deprecated: Setting the "framework.http_cache.terminate_on_cache_hit.terminate_on_cache_hit" configuration option is deprecated. It will be removed in version 9.0.
 *     },
 *     esi?: bool|array{ // ESI configuration
 *         enabled?: bool|Param, // Default: false
 *     },
 *     ssi?: bool|array{ // SSI configuration
 *         enabled?: bool|Param, // Default: false
 *     },
 *     fragments?: bool|array{ // Fragments configuration
 *         enabled?: bool|Param, // Default: false
 *         hinclude_default_template?: scalar|Param|null, // Default: null
 *         path?: scalar|Param|null, // Default: "/_fragment"
 *     },
 *     profiler?: bool|array{ // Profiler configuration
 *         enabled?: bool|Param, // Default: false
 *         collect?: bool|Param, // Default: true
 *         collect_parameter?: scalar|Param|null, // The name of the parameter to use to enable or disable collection on a per request basis. // Default: null
 *         only_exceptions?: bool|Param, // Default: false
 *         only_main_requests?: bool|Param, // Default: false
 *         dsn?: scalar|Param|null, // Default: "file:%kernel.cache_dir%/profiler"
 *         collect_serializer_data?: true|Param, // Deprecated: Setting the "framework.profiler.collect_serializer_data.collect_serializer_data" configuration option is deprecated. It will be removed in version 9.0. // Default: true
 *     },
 *     workflows?: bool|array{
 *         enabled?: bool|Param, // Default: false
 *         workflows?: array<string, array{ // Default: []
 *             audit_trail?: bool|array{
 *                 enabled?: bool|Param, // Default: false
 *             },
 *             type?: "workflow"|"state_machine"|Param, // Default: "state_machine"
 *             marking_store?: array{
 *                 type?: "method"|Param,
 *                 property?: scalar|Param|null,
 *                 service?: scalar|Param|null,
 *             },
 *             supports?: Param|string|list<scalar|Param|null>,
 *             definition_validators?: list<scalar|Param|null>,
 *             support_strategy?: scalar|Param|null,
 *             initial_marking?: \BackedEnum|Param|string|list<scalar|Param|null>,
 *             events_to_dispatch?: null|list<string|Param>,
 *             places?: Param|string|list<array{ // Default: []
 *                 name?: scalar|Param|null,
 *                 metadata?: array<string, mixed>,
 *             }>,
 *             transitions?: list<array{ // Default: []
 *                 name?: string|Param,
 *                 guard?: string|Param, // An expression to block the transition.
 *                 from?: \BackedEnum|Param|string|list<array{ // Default: []
 *                     place?: string|Param,
 *                     weight?: int|Param, // Default: 1
 *                 }>,
 *                 to?: \BackedEnum|Param|string|list<array{ // Default: []
 *                     place?: string|Param,
 *                     weight?: int|Param, // Default: 1
 *                 }>,
 *                 weight?: int|Param, // Default: 1
 *                 metadata?: array<string, mixed>,
 *             }>,
 *             metadata?: array<string, mixed>,
 *         }>,
 *     },
 *     router?: bool|array{ // Router configuration
 *         enabled?: bool|Param, // Default: false
 *         resource?: scalar|Param|null,
 *         type?: scalar|Param|null,
 *         default_uri?: scalar|Param|null, // The default URI used to generate URLs in a non-HTTP context. // Default: null
 *         http_port?: scalar|Param|null, // Default: 80
 *         https_port?: scalar|Param|null, // Default: 443
 *         strict_requirements?: scalar|Param|null, // set to true to throw an exception when a parameter does not match the requirements set to false to disable exceptions when a parameter does not match the requirements (and return null instead) set to null to disable parameter checks against requirements 'true' is the preferred configuration in development mode, while 'false' or 'null' might be preferred in production // Default: true
 *         utf8?: bool|Param, // Default: true
 *     },
 *     session?: bool|array{ // Session configuration
 *         enabled?: bool|Param, // Default: false
 *         storage_factory_id?: scalar|Param|null, // Default: "session.storage.factory.native"
 *         handler_id?: scalar|Param|null, // Defaults to using the native session handler, or to the native *file* session handler if "save_path" is not null.
 *         name?: scalar|Param|null,
 *         cookie_lifetime?: scalar|Param|null,
 *         cookie_path?: scalar|Param|null,
 *         cookie_domain?: scalar|Param|null,
 *         cookie_secure?: true|false|"auto"|Param, // Default: "auto"
 *         cookie_httponly?: bool|Param, // Default: true
 *         cookie_samesite?: null|"lax"|"strict"|"none"|Param, // Default: "lax"
 *         use_cookies?: bool|Param,
 *         gc_divisor?: scalar|Param|null,
 *         gc_probability?: scalar|Param|null,
 *         gc_maxlifetime?: scalar|Param|null,
 *         save_path?: scalar|Param|null, // Defaults to "%kernel.cache_dir%/sessions" if the "handler_id" option is not null.
 *         metadata_update_threshold?: int|Param, // Seconds to wait between 2 session metadata updates. // Default: 0
 *     },
 *     request?: bool|array{ // Request configuration
 *         enabled?: bool|Param, // Default: false
 *         formats?: array<string, Param|string|list<scalar|Param|null>>,
 *     },
 *     assets?: bool|array{ // Assets configuration
 *         enabled?: bool|Param, // Default: true
 *         strict_mode?: bool|Param, // Throw an exception if an entry is missing from the manifest.json. // Default: false
 *         version_strategy?: scalar|Param|null, // Default: null
 *         version?: scalar|Param|null, // Default: null
 *         version_format?: scalar|Param|null, // Default: "%%s?%%s"
 *         json_manifest_path?: scalar|Param|null, // Default: null
 *         base_path?: scalar|Param|null, // Default: ""
 *         base_urls?: Param|string|list<scalar|Param|null>,
 *         packages?: array<string, array{ // Default: []
 *             strict_mode?: bool|Param, // Throw an exception if an entry is missing from the manifest.json. // Default: false
 *             version_strategy?: scalar|Param|null, // Default: null
 *             version?: scalar|Param|null,
 *             version_format?: scalar|Param|null, // Default: null
 *             json_manifest_path?: scalar|Param|null, // Default: null
 *             base_path?: scalar|Param|null, // Default: ""
 *             base_urls?: Param|string|list<scalar|Param|null>,
 *         }>,
 *     },
 *     asset_mapper?: bool|array{ // Asset Mapper configuration
 *         enabled?: bool|Param, // Default: false
 *         paths?: Param|string|array<string, scalar|Param|null>,
 *         excluded_patterns?: list<scalar|Param|null>,
 *         exclude_dotfiles?: bool|Param, // If true, any files starting with "." will be excluded from the asset mapper. // Default: true
 *         server?: bool|Param, // If true, a "dev server" will return the assets from the public directory (true in "debug" mode only by default). // Default: true
 *         public_prefix?: scalar|Param|null, // The public path where the assets will be written to (and served from when "server" is true). // Default: "/assets/"
 *         missing_import_mode?: "strict"|"warn"|"ignore"|Param, // Behavior if an asset cannot be found when imported from JavaScript or CSS files - e.g. "import './non-existent.js'". "strict" means an exception is thrown, "warn" means a warning is logged, "ignore" means the import is left as-is. // Default: "warn"
 *         extensions?: array<string, scalar|Param|null>,
 *         importmap_path?: scalar|Param|null, // The path of the importmap.php file. // Default: "%kernel.project_dir%/importmap.php"
 *         importmap_polyfill?: scalar|Param|null, // The importmap name that will be used to load the polyfill. Set to false to disable. // Default: "es-module-shims"
 *         importmap_script_attributes?: array<string, scalar|Param|null>,
 *         vendor_dir?: scalar|Param|null, // The directory to store JavaScript vendors. // Default: "%kernel.project_dir%/assets/vendor"
 *         precompress?: bool|array{ // Precompress assets with Brotli, Zstandard and gzip.
 *             enabled?: bool|Param, // Default: false
 *             formats?: list<scalar|Param|null>,
 *             extensions?: list<scalar|Param|null>,
 *         },
 *     },
 *     translator?: bool|array{ // Translator configuration
 *         enabled?: bool|Param, // Default: true
 *         fallbacks?: Param|string|list<scalar|Param|null>,
 *         logging?: bool|Param, // Default: false
 *         formatter?: scalar|Param|null, // Default: "translator.formatter.default"
 *         cache_dir?: scalar|Param|null, // Default: "%kernel.cache_dir%/translations"
 *         default_path?: scalar|Param|null, // The default path used to load translations. // Default: "%kernel.project_dir%/translations"
 *         paths?: list<scalar|Param|null>,
 *         pseudo_localization?: bool|array{
 *             enabled?: bool|Param, // Default: false
 *             accents?: bool|Param, // Default: true
 *             expansion_factor?: float|Param, // Default: 1.0
 *             brackets?: bool|Param, // Default: true
 *             parse_html?: bool|Param, // Default: false
 *             localizable_html_attributes?: list<scalar|Param|null>,
 *         },
 *         providers?: array<string, array{ // Default: []
 *             dsn?: scalar|Param|null,
 *             domains?: list<scalar|Param|null>,
 *             locales?: list<scalar|Param|null>,
 *         }>,
 *         globals?: array<string, Param|string|array{ // Default: []
 *             value?: mixed,
 *             message?: string|Param,
 *             parameters?: array<string, scalar|Param|null>,
 *             domain?: string|Param,
 *         }>,
 *     },
 *     validation?: bool|array{ // Validation configuration
 *         enabled?: bool|Param, // Default: true
 *         enable_attributes?: bool|Param, // Default: true
 *         static_method?: Param|string|list<scalar|Param|null>,
 *         translation_domain?: scalar|Param|null, // Default: "validators"
 *         email_validation_mode?: "html5"|"html5-allow-no-tld"|"strict"|Param, // Default: "html5"
 *         mapping?: array{
 *             paths?: list<scalar|Param|null>,
 *         },
 *         not_compromised_password?: bool|array{
 *             enabled?: bool|Param, // When disabled, compromised passwords will be accepted as valid. // Default: true
 *             endpoint?: scalar|Param|null, // API endpoint for the NotCompromisedPassword Validator. // Default: null
 *         },
 *         disable_translation?: bool|Param, // Default: false
 *         property_metadata_existence_check?: bool|Param, // When enabled, validateProperty() and validatePropertyValue() throw an exception if no metadata is found for the given property. // Default: false
 *         auto_mapping?: array<string, array{ // Default: []
 *             services?: list<scalar|Param|null>,
 *         }>,
 *     },
 *     serializer?: bool|array{ // Serializer configuration
 *         enabled?: bool|Param, // Default: true
 *         enable_attributes?: bool|Param, // Default: true
 *         name_converter?: scalar|Param|null,
 *         circular_reference_handler?: scalar|Param|null,
 *         max_depth_handler?: scalar|Param|null,
 *         mapping?: array{
 *             paths?: list<scalar|Param|null>,
 *         },
 *         default_context?: array<string, mixed>,
 *         named_serializers?: array<string, array{ // Default: []
 *             name_converter?: scalar|Param|null,
 *             default_context?: array<string, mixed>,
 *             include_built_in_normalizers?: bool|Param, // Whether to include the built-in normalizers // Default: true
 *             include_built_in_encoders?: bool|Param, // Whether to include the built-in encoders // Default: true
 *         }>,
 *     },
 *     property_access?: bool|array{ // Property access configuration
 *         enabled?: bool|Param, // Default: true
 *         magic_call?: bool|Param, // Default: false
 *         magic_get?: bool|Param, // Default: true
 *         magic_set?: bool|Param, // Default: true
 *         throw_exception_on_invalid_index?: bool|Param, // Default: false
 *         throw_exception_on_invalid_property_path?: bool|Param, // Default: true
 *     },
 *     type_info?: bool|array{ // Type info configuration
 *         enabled?: bool|Param, // Default: true
 *         aliases?: array<string, scalar|Param|null>,
 *     },
 *     property_info?: bool|array{ // Property info configuration
 *         enabled?: bool|Param, // Default: true
 *         with_constructor_extractor?: bool|Param, // Registers the constructor extractor. // Default: true
 *     },
 *     cache?: array{ // Cache configuration
 *         prefix_seed?: scalar|Param|null, // Used to namespace cache keys when using several apps with the same shared backend. // Default: "_%kernel.project_dir%.%kernel.container_class%"
 *         app?: scalar|Param|null, // App related cache pools configuration. // Default: "cache.adapter.filesystem"
 *         system?: scalar|Param|null, // System related cache pools configuration. // Default: "cache.adapter.system"
 *         directory?: scalar|Param|null, // Default: "%kernel.share_dir%/pools/app"
 *         default_psr6_provider?: scalar|Param|null,
 *         default_redis_provider?: scalar|Param|null, // Default: "redis://localhost"
 *         default_valkey_provider?: scalar|Param|null, // Default: "valkey://localhost"
 *         default_memcached_provider?: scalar|Param|null, // Default: "memcached://localhost"
 *         default_doctrine_dbal_provider?: scalar|Param|null, // Default: "database_connection"
 *         default_pdo_provider?: scalar|Param|null, // Default: null
 *         pools?: array<string, array{ // Default: []
 *             adapters?: Param|string|list<scalar|Param|null>,
 *             tags?: scalar|Param|null, // Default: null
 *             public?: bool|Param, // Default: false
 *             default_lifetime?: scalar|Param|null, // Default lifetime of the pool.
 *             provider?: scalar|Param|null, // Overwrite the setting from the default provider for this adapter.
 *             early_expiration_message_bus?: scalar|Param|null,
 *             clearer?: scalar|Param|null,
 *             marshaller?: scalar|Param|null, // The marshaller service to use for this pool.
 *         }>,
 *     },
 *     php_errors?: array{ // PHP errors handling configuration
 *         log?: mixed, // Use the application logger instead of the PHP logger for logging PHP errors. // Default: true
 *         throw?: bool|Param, // Throw PHP errors as \ErrorException instances. // Default: true
 *     },
 *     exceptions?: array<string, array{ // Default: []
 *         log_level?: scalar|Param|null, // The level of log message. Null to let Symfony decide. // Default: null
 *         status_code?: scalar|Param|null, // The status code of the response. Null or 0 to let Symfony decide. // Default: null
 *         log_channel?: scalar|Param|null, // The channel of log message. Null to let Symfony decide. // Default: null
 *     }>,
 *     web_link?: bool|array{ // Web links configuration
 *         enabled?: bool|Param, // Default: false
 *     },
 *     lock?: Param|bool|string|array{ // Lock configuration
 *         enabled?: bool|Param, // Default: false
 *         resources?: Param|string|array<string, Param|string|list<scalar|Param|null>>,
 *     },
 *     semaphore?: Param|bool|string|array{ // Semaphore configuration
 *         enabled?: bool|Param, // Default: false
 *         resources?: Param|string|array<string, scalar|Param|null>,
 *     },
 *     messenger?: bool|array{ // Messenger configuration
 *         enabled?: bool|Param, // Default: true
 *         routing?: array<string, Param|string|list<scalar|Param|null>>,
 *         serializer?: array{
 *             default_serializer?: scalar|Param|null, // Service id to use as the default serializer for the transports. // Default: "messenger.transport.native_php_serializer"
 *             symfony_serializer?: array{
 *                 format?: scalar|Param|null, // Serialization format for the messenger.transport.symfony_serializer service (which is not the serializer used by default). // Default: "json"
 *                 context?: array<string, mixed>,
 *             },
 *         },
 *         transports?: array<string, Param|string|array{ // Default: []
 *             dsn?: scalar|Param|null,
 *             serializer?: scalar|Param|null, // Service id of a custom serializer to use. // Default: null
 *             options?: array<string, mixed>,
 *             failure_transport?: scalar|Param|null, // Transport name to send failed messages to (after all retries have failed). // Default: null
 *             retry_strategy?: Param|string|array{
 *                 service?: scalar|Param|null, // Service id to override the retry strategy entirely. // Default: null
 *                 max_retries?: int|Param, // Default: 3
 *                 delay?: int|Param, // Time in ms to delay (or the initial value when multiplier is used). // Default: 1000
 *                 multiplier?: float|Param, // If greater than 1, delay will grow exponentially for each retry: this delay = (delay * (multiple ^ retries)). // Default: 2
 *                 max_delay?: int|Param, // Max time in ms that a retry should ever be delayed (0 = infinite). // Default: 0
 *                 jitter?: float|Param, // Randomness to apply to the delay (between 0 and 1). // Default: 0.1
 *             },
 *             rate_limiter?: scalar|Param|null, // Rate limiter name to use when processing messages. // Default: null
 *         }>,
 *         failure_transport?: scalar|Param|null, // Transport name to send failed messages to (after all retries have failed). // Default: null
 *         stop_worker_on_signals?: Param|int|string|list<scalar|Param|null>,
 *         default_bus?: scalar|Param|null, // Default: null
 *         buses?: array<string, array{ // Default: {"messenger.bus.default":{"default_middleware":{"enabled":true,"allow_no_handlers":false,"allow_no_senders":true},"middleware":[]}}
 *             default_middleware?: Param|bool|string|array{
 *                 enabled?: bool|Param, // Default: true
 *                 allow_no_handlers?: bool|Param, // Default: false
 *                 allow_no_senders?: bool|Param, // Default: true
 *             },
 *             middleware?: Param|string|list<Param|string|array{ // Default: []
 *                 id?: scalar|Param|null,
 *                 arguments?: list<mixed>,
 *             }>,
 *         }>,
 *     },
 *     scheduler?: bool|array{ // Scheduler configuration
 *         enabled?: bool|Param, // Default: false
 *     },
 *     disallow_search_engine_index?: bool|Param, // Enabled by default when debug is enabled. // Default: true
 *     http_client?: bool|array{ // HTTP Client configuration
 *         enabled?: bool|Param, // Default: true
 *         max_host_connections?: int|Param, // The maximum number of connections to a single host.
 *         default_options?: array{
 *             headers?: array<string, mixed>,
 *             vars?: array<string, mixed>,
 *             max_redirects?: int|Param, // The maximum number of redirects to follow.
 *             http_version?: scalar|Param|null, // The default HTTP version, typically 1.1 or 2.0, leave to null for the best version.
 *             resolve?: array<string, scalar|Param|null>,
 *             proxy?: scalar|Param|null, // The URL of the proxy to pass requests through or null for automatic detection.
 *             no_proxy?: scalar|Param|null, // A comma separated list of hosts that do not require a proxy to be reached.
 *             timeout?: float|Param, // The idle timeout, defaults to the "default_socket_timeout" ini parameter.
 *             max_duration?: float|Param, // The maximum execution time for the request+response as a whole.
 *             bindto?: scalar|Param|null, // A network interface name, IP address, a host name or a UNIX socket to bind to.
 *             verify_peer?: bool|Param, // Indicates if the peer should be verified in a TLS context.
 *             verify_host?: bool|Param, // Indicates if the host should exist as a certificate common name.
 *             cafile?: scalar|Param|null, // A certificate authority file.
 *             capath?: scalar|Param|null, // A directory that contains multiple certificate authority files.
 *             local_cert?: scalar|Param|null, // A PEM formatted certificate file.
 *             local_pk?: scalar|Param|null, // A private key file.
 *             passphrase?: scalar|Param|null, // The passphrase used to encrypt the "local_pk" file.
 *             ciphers?: scalar|Param|null, // A list of TLS ciphers separated by colons, commas or spaces (e.g. "RC3-SHA:TLS13-AES-128-GCM-SHA256"...)
 *             peer_fingerprint?: array{ // Associative array: hashing algorithm => hash(es).
 *                 sha1?: mixed,
 *                 pin-sha256?: mixed,
 *                 md5?: mixed,
 *             },
 *             crypto_method?: scalar|Param|null, // The minimum version of TLS to accept; must be one of STREAM_CRYPTO_METHOD_TLSv*_CLIENT constants.
 *             extra?: array<string, mixed>,
 *             rate_limiter?: scalar|Param|null, // Rate limiter name to use for throttling requests. // Default: null
 *             caching?: bool|array{ // Caching configuration.
 *                 enabled?: bool|Param, // Default: false
 *                 cache_pool?: string|Param, // The taggable cache pool to use for storing the responses. // Default: "cache.http_client"
 *                 shared?: bool|Param, // Indicates whether the cache is shared (public) or private. // Default: true
 *                 max_ttl?: int|Param, // The maximum TTL (in seconds) allowed for cached responses. // Default: 86400
 *             },
 *             retry_failed?: bool|array{
 *                 enabled?: bool|Param, // Default: false
 *                 retry_strategy?: scalar|Param|null, // service id to override the retry strategy. // Default: null
 *                 http_codes?: Param|int|string|array<string, array{ // Default: []
 *                     code?: int|Param,
 *                     methods?: Param|string|list<string|Param>,
 *                 }>,
 *                 max_retries?: int|Param, // Default: 3
 *                 delay?: int|Param, // Time in ms to delay (or the initial value when multiplier is used). // Default: 1000
 *                 multiplier?: float|Param, // If greater than 1, delay will grow exponentially for each retry: delay * (multiple ^ retries). // Default: 2
 *                 max_delay?: int|Param, // Max time in ms that a retry should ever be delayed (0 = infinite). // Default: 0
 *                 jitter?: float|Param, // Randomness in percent (between 0 and 1) to apply to the delay. // Default: 0.1
 *             },
 *         },
 *         mock_response_factory?: scalar|Param|null, // `true` to always return empty 200 responses, or the id of the service to use to generate mock responses - which should be either an invokable or an iterable.
 *         scoped_clients?: array<string, Param|string|array{ // Default: []
 *             scope?: scalar|Param|null, // The regular expression that the request URL must match before adding the other options. When none is provided, the base URI is used instead.
 *             base_uri?: scalar|Param|null, // The URI to resolve relative URLs, following rules in RFC 3985, section 2.
 *             auth_basic?: scalar|Param|null, // An HTTP Basic authentication "username:password".
 *             auth_bearer?: scalar|Param|null, // A token enabling HTTP Bearer authorization.
 *             auth_ntlm?: scalar|Param|null, // A "username:password" pair to use Microsoft NTLM authentication (requires the cURL extension).
 *             query?: array<string, scalar|Param|null>,
 *             headers?: array<string, mixed>,
 *             max_redirects?: int|Param, // The maximum number of redirects to follow.
 *             http_version?: scalar|Param|null, // The default HTTP version, typically 1.1 or 2.0, leave to null for the best version.
 *             resolve?: array<string, scalar|Param|null>,
 *             proxy?: scalar|Param|null, // The URL of the proxy to pass requests through or null for automatic detection.
 *             no_proxy?: scalar|Param|null, // A comma separated list of hosts that do not require a proxy to be reached.
 *             timeout?: float|Param, // The idle timeout, defaults to the "default_socket_timeout" ini parameter.
 *             max_duration?: float|Param, // The maximum execution time for the request+response as a whole.
 *             bindto?: scalar|Param|null, // A network interface name, IP address, a host name or a UNIX socket to bind to.
 *             verify_peer?: bool|Param, // Indicates if the peer should be verified in a TLS context.
 *             verify_host?: bool|Param, // Indicates if the host should exist as a certificate common name.
 *             cafile?: scalar|Param|null, // A certificate authority file.
 *             capath?: scalar|Param|null, // A directory that contains multiple certificate authority files.
 *             local_cert?: scalar|Param|null, // A PEM formatted certificate file.
 *             local_pk?: scalar|Param|null, // A private key file.
 *             passphrase?: scalar|Param|null, // The passphrase used to encrypt the "local_pk" file.
 *             ciphers?: scalar|Param|null, // A list of TLS ciphers separated by colons, commas or spaces (e.g. "RC3-SHA:TLS13-AES-128-GCM-SHA256"...).
 *             peer_fingerprint?: array{ // Associative array: hashing algorithm => hash(es).
 *                 sha1?: mixed,
 *                 pin-sha256?: mixed,
 *                 md5?: mixed,
 *             },
 *             crypto_method?: scalar|Param|null, // The minimum version of TLS to accept; must be one of STREAM_CRYPTO_METHOD_TLSv*_CLIENT constants.
 *             mock_response_factory?: scalar|Param|null, // `true` to always return empty 200 responses, `false` to disable mocking, or the id of the service to use to generate mock responses (invokable or iterable).
 *             extra?: array<string, mixed>,
 *             rate_limiter?: scalar|Param|null, // Rate limiter name to use for throttling requests. // Default: null
 *             caching?: bool|array{ // Caching configuration.
 *                 enabled?: bool|Param, // Default: false
 *                 cache_pool?: string|Param, // The taggable cache pool to use for storing the responses. // Default: "cache.http_client"
 *                 shared?: bool|Param, // Indicates whether the cache is shared (public) or private. // Default: true
 *                 max_ttl?: int|Param, // The maximum TTL (in seconds) allowed for cached responses. // Default: 86400
 *             },
 *             retry_failed?: bool|array{
 *                 enabled?: bool|Param, // Default: false
 *                 retry_strategy?: scalar|Param|null, // service id to override the retry strategy. // Default: null
 *                 http_codes?: Param|int|string|array<string, array{ // Default: []
 *                     code?: int|Param,
 *                     methods?: Param|string|list<string|Param>,
 *                 }>,
 *                 max_retries?: int|Param, // Default: 3
 *                 delay?: int|Param, // Time in ms to delay (or the initial value when multiplier is used). // Default: 1000
 *                 multiplier?: float|Param, // If greater than 1, delay will grow exponentially for each retry: delay * (multiple ^ retries). // Default: 2
 *                 max_delay?: int|Param, // Max time in ms that a retry should ever be delayed (0 = infinite). // Default: 0
 *                 jitter?: float|Param, // Randomness in percent (between 0 and 1) to apply to the delay. // Default: 0.1
 *             },
 *         }>,
 *     },
 *     mailer?: bool|array{ // Mailer configuration
 *         enabled?: bool|Param, // Default: true
 *         message_bus?: scalar|Param|null, // The message bus to use. Defaults to the default bus if the Messenger component is installed. // Default: null
 *         dsn?: scalar|Param|null, // Default: null
 *         transports?: array<string, scalar|Param|null>,
 *         envelope?: array{ // Mailer Envelope configuration
 *             sender?: scalar|Param|null,
 *             recipients?: Param|string|list<scalar|Param|null>,
 *             allowed_recipients?: Param|string|list<scalar|Param|null>,
 *         },
 *         headers?: array<string, Param|string|array{ // Default: []
 *             value?: mixed,
 *         }>,
 *         dkim_signer?: bool|array{ // DKIM signer configuration
 *             enabled?: bool|Param, // Default: false
 *             key?: scalar|Param|null, // Key content, or path to key (in PEM format with the `file://` prefix) // Default: ""
 *             domain?: scalar|Param|null, // Default: ""
 *             select?: scalar|Param|null, // Default: ""
 *             passphrase?: scalar|Param|null, // The private key passphrase // Default: ""
 *             options?: array<string, mixed>,
 *         },
 *         smime_signer?: bool|array{ // S/MIME signer configuration
 *             enabled?: bool|Param, // Default: false
 *             key?: scalar|Param|null, // Path to key (in PEM format) // Default: ""
 *             certificate?: scalar|Param|null, // Path to certificate (in PEM format without the `file://` prefix) // Default: ""
 *             passphrase?: scalar|Param|null, // The private key passphrase // Default: null
 *             extra_certificates?: scalar|Param|null, // Default: null
 *             sign_options?: int|Param, // Default: null
 *         },
 *         smime_encrypter?: bool|array{ // S/MIME encrypter configuration
 *             enabled?: bool|Param, // Default: false
 *             repository?: scalar|Param|null, // S/MIME certificate repository service. This service shall implement the `Symfony\Component\Mailer\EventListener\SmimeCertificateRepositoryInterface`. // Default: ""
 *             cipher?: int|Param, // A set of algorithms used to encrypt the message // Default: null
 *         },
 *     },
 *     secrets?: bool|array{
 *         enabled?: bool|Param, // Default: true
 *         vault_directory?: scalar|Param|null, // Default: "%kernel.project_dir%/config/secrets/%kernel.runtime_environment%"
 *         local_dotenv_file?: scalar|Param|null, // Default: "%kernel.project_dir%/.env.%kernel.environment%.local"
 *         decryption_env_var?: scalar|Param|null, // Default: "base64:default::SYMFONY_DECRYPTION_SECRET"
 *     },
 *     notifier?: bool|array{ // Notifier configuration
 *         enabled?: bool|Param, // Default: false
 *         message_bus?: scalar|Param|null, // The message bus to use. Defaults to the default bus if the Messenger component is installed. // Default: null
 *         chatter_transports?: array<string, scalar|Param|null>,
 *         texter_transports?: array<string, scalar|Param|null>,
 *         notification_on_failed_messages?: bool|Param, // Default: false
 *         channel_policy?: array<string, Param|string|list<scalar|Param|null>>,
 *         admin_recipients?: list<array{ // Default: []
 *             email?: scalar|Param|null,
 *             phone?: scalar|Param|null, // Default: ""
 *         }>,
 *     },
 *     rate_limiter?: bool|array{ // Rate limiter configuration
 *         enabled?: bool|Param, // Default: true
 *         limiters?: array<string, array{ // Default: []
 *             lock_factory?: scalar|Param|null, // The service ID of the lock factory used by this limiter (or null to disable locking). // Default: "auto"
 *             cache_pool?: scalar|Param|null, // The cache pool to use for storing the current limiter state. // Default: "cache.rate_limiter"
 *             storage_service?: scalar|Param|null, // The service ID of a custom storage implementation, this precedes any configured "cache_pool". // Default: null
 *             policy?: "fixed_window"|"token_bucket"|"sliding_window"|"compound"|"no_limit"|Param, // The algorithm to be used by this limiter.
 *             limiters?: Param|string|list<scalar|Param|null>,
 *             limit?: int|Param, // The maximum allowed hits in a fixed interval or burst.
 *             interval?: scalar|Param|null, // Configures the fixed interval if "policy" is set to "fixed_window" or "sliding_window". The value must be a number followed by "second", "minute", "hour", "day", "week" or "month" (or their plural equivalent).
 *             rate?: array{ // Configures the fill rate if "policy" is set to "token_bucket".
 *                 interval?: scalar|Param|null, // Configures the rate interval. The value must be a number followed by "second", "minute", "hour", "day", "week" or "month" (or their plural equivalent).
 *                 amount?: int|Param, // Amount of tokens to add each interval. // Default: 1
 *             },
 *             anchor_at?: scalar|Param|null, // Aligns the "fixed_window" policy to a calendar (e.g. "2024-01-05 00:00:00 UTC" combined with `interval: 1 month` resets the counter on the 5th of each month). UTC if not specified. // Default: null
 *         }>,
 *     },
 *     uid?: bool|array{ // Uid configuration
 *         enabled?: bool|Param, // Default: true
 *         default_uuid_version?: 7|6|4|1|Param, // Default: 7
 *         name_based_uuid_version?: 5|3|Param, // Default: 5
 *         name_based_uuid_namespace?: scalar|Param|null,
 *         time_based_uuid_version?: 7|6|1|Param, // Default: 7
 *         time_based_uuid_node?: scalar|Param|null,
 *         uuid47_secret?: scalar|Param|null, // A high-entropy secret used by the "uuid47_transformer" service. Defaults to "kernel.secret". // Default: null
 *     },
 *     html_sanitizer?: bool|array{ // HtmlSanitizer configuration
 *         enabled?: bool|Param, // Default: true
 *         sanitizers?: array<string, array{ // Default: []
 *             default_action?: "drop"|"block"|"allow"|Param, // Defines how the sanitizer must behave by default.
 *             allow_safe_elements?: bool|Param, // Allows "safe" elements and attributes. // Default: false
 *             allow_static_elements?: bool|Param, // Allows all static elements and attributes from the W3C Sanitizer API standard. // Default: false
 *             allow_elements?: array<string, mixed>,
 *             block_elements?: Param|string|list<string|Param>,
 *             drop_elements?: Param|string|list<string|Param>,
 *             allow_attributes?: array<string, mixed>,
 *             drop_attributes?: array<string, mixed>,
 *             force_attributes?: array<string, array<string, string|Param>>,
 *             force_https_urls?: bool|Param, // Transforms URLs using the HTTP scheme to use the HTTPS scheme instead. // Default: false
 *             allowed_link_schemes?: Param|string|list<string|Param>,
 *             allowed_link_hosts?: Param|null|string|list<string|Param>,
 *             allow_relative_links?: bool|Param, // Allows relative URLs to be used in links href attributes. // Default: false
 *             allowed_media_schemes?: Param|string|list<string|Param>,
 *             allowed_media_hosts?: Param|null|string|list<string|Param>,
 *             allow_relative_medias?: bool|Param, // Allows relative URLs to be used in media source attributes (img, audio, video, ...). // Default: false
 *             with_attribute_sanitizers?: Param|string|list<string|Param>,
 *             without_attribute_sanitizers?: Param|string|list<string|Param>,
 *             max_input_length?: int|Param, // The maximum length allowed for the sanitized input. // Default: 0
 *         }>,
 *     },
 *     webhook?: bool|array{ // Webhook configuration
 *         enabled?: bool|Param, // Default: false
 *         message_bus?: scalar|Param|null, // The message bus to use. // Default: "messenger.default_bus"
 *         event_header_name?: scalar|Param|null, // Default: "Webhook-Event"
 *         id_header_name?: scalar|Param|null, // Default: "Webhook-Id"
 *         signature_header_name?: scalar|Param|null, // Default: "Webhook-Signature"
 *         signing_algorithm?: scalar|Param|null, // Default: "sha256"
 *         routing?: array<string, array{ // Default: []
 *             service?: scalar|Param|null,
 *             secret?: scalar|Param|null, // The secret used to verify incoming request signatures. It must be set in production: with an empty value, depending on the parser, requests from any sender are accepted or every request is rejected. // Default: ""
 *         }>,
 *     },
 *     remote_event?: bool|array{ // RemoteEvent configuration
 *         enabled?: bool|Param, // Default: false
 *     },
 *     json_streamer?: bool|array{ // JSON streamer configuration
 *         enabled?: bool|Param, // Default: false
 *         default_options?: array{
 *             include_null_properties?: bool|Param, // Encode the properties with null value // Default: false
 *             ...<string, mixed>
 *         },
 *     },
 * }
 * @psalm-type WebpackEncoreConfig = array{
 *     output_path?: scalar|Param|null, // The path where Encore is building the assets - i.e. Encore.setOutputPath()
 *     crossorigin?: false|"anonymous"|"use-credentials"|Param, // crossorigin value when Encore.enableIntegrityHashes() is used, can be false (default), anonymous or use-credentials // Default: false
 *     preload?: bool|Param, // preload all rendered script and link tags automatically via the http2 Link header. // Default: false
 *     cache?: bool|Param, // Enable caching of the entry point file(s) // Default: false
 *     strict_mode?: bool|Param, // Throw an exception if the entrypoints.json file is missing or an entry is missing from the data // Default: true
 *     builds?: array<string, scalar|Param|null>,
 *     script_attributes?: array<string, scalar|Param|null>,
 *     link_attributes?: array<string, scalar|Param|null>,
 * }
 * @psalm-type DoctrineConfig = array{
 *     dbal?: array{
 *         default_connection?: scalar|Param|null,
 *         types?: array<string, Param|string|array{ // Default: []
 *             class?: scalar|Param|null,
 *         }>,
 *         driver_schemes?: array<string, scalar|Param|null>,
 *         connections?: array<string, array{ // Default: []
 *             url?: scalar|Param|null, // A URL with connection information; any parameter value parsed from this string will override explicitly set parameters
 *             dbname?: scalar|Param|null,
 *             host?: scalar|Param|null, // Defaults to "localhost" at runtime.
 *             port?: scalar|Param|null, // Defaults to null at runtime.
 *             user?: scalar|Param|null, // Defaults to "root" at runtime.
 *             password?: scalar|Param|null, // Defaults to null at runtime.
 *             dbname_suffix?: scalar|Param|null, // Adds the given suffix to the configured database name, this option has no effects for the SQLite platform
 *             application_name?: scalar|Param|null,
 *             charset?: scalar|Param|null,
 *             path?: scalar|Param|null,
 *             memory?: bool|Param,
 *             unix_socket?: scalar|Param|null, // The unix socket to use for MySQL
 *             persistent?: bool|Param, // True to use as persistent connection for the ibm_db2 driver
 *             protocol?: scalar|Param|null, // The protocol to use for the ibm_db2 driver (default to TCPIP if omitted)
 *             service?: bool|Param, // True to use SERVICE_NAME as connection parameter instead of SID for Oracle
 *             servicename?: scalar|Param|null, // Overrules dbname parameter if given and used as SERVICE_NAME or SID connection parameter for Oracle depending on the service parameter.
 *             sessionMode?: scalar|Param|null, // The session mode to use for the oci8 driver
 *             server?: scalar|Param|null, // The name of a running database server to connect to for SQL Anywhere.
 *             default_dbname?: scalar|Param|null, // Override the default database (postgres) to connect to for PostgreSQL connection.
 *             sslmode?: scalar|Param|null, // Determines whether or with what priority a SSL TCP/IP connection will be negotiated with the server for PostgreSQL.
 *             sslrootcert?: scalar|Param|null, // The name of a file containing SSL certificate authority (CA) certificate(s). If the file exists, the server's certificate will be verified to be signed by one of these authorities.
 *             sslcert?: scalar|Param|null, // The path to the SSL client certificate file for PostgreSQL.
 *             sslkey?: scalar|Param|null, // The path to the SSL client key file for PostgreSQL.
 *             sslcrl?: scalar|Param|null, // The file name of the SSL certificate revocation list for PostgreSQL.
 *             pooled?: bool|Param, // True to use a pooled server with the oci8/pdo_oracle driver
 *             MultipleActiveResultSets?: bool|Param, // Configuring MultipleActiveResultSets for the pdo_sqlsrv driver
 *             instancename?: scalar|Param|null, // Optional parameter, complete whether to add the INSTANCE_NAME parameter in the connection. It is generally used to connect to an Oracle RAC server to select the name of a particular instance.
 *             connectstring?: scalar|Param|null, // Complete Easy Connect connection descriptor, see https://docs.oracle.com/database/121/NETAG/naming.htm.When using this option, you will still need to provide the user and password parameters, but the other parameters will no longer be used. Note that when using this parameter, the getHost and getPort methods from Doctrine\DBAL\Connection will no longer function as expected.
 *             driver?: scalar|Param|null, // Default: "pdo_mysql"
 *             auto_commit?: bool|Param,
 *             schema_filter?: scalar|Param|null,
 *             logging?: bool|Param, // Default: true
 *             profiling?: bool|Param, // Default: true
 *             profiling_collect_backtrace?: bool|Param, // Enables collecting backtraces when profiling is enabled // Default: false
 *             profiling_collect_schema_errors?: bool|Param, // Enables collecting schema errors when profiling is enabled // Default: true
 *             server_version?: scalar|Param|null,
 *             idle_connection_ttl?: int|Param, // Default: 600
 *             driver_class?: scalar|Param|null,
 *             wrapper_class?: scalar|Param|null,
 *             keep_replica?: bool|Param,
 *             options?: array<string, mixed>,
 *             mapping_types?: array<string, scalar|Param|null>,
 *             default_table_options?: array<string, scalar|Param|null>,
 *             schema_manager_factory?: scalar|Param|null, // Default: "doctrine.dbal.default_schema_manager_factory"
 *             result_cache?: scalar|Param|null,
 *             replicas?: array<string, array{ // Default: []
 *                 url?: scalar|Param|null, // A URL with connection information; any parameter value parsed from this string will override explicitly set parameters
 *                 dbname?: scalar|Param|null,
 *                 host?: scalar|Param|null, // Defaults to "localhost" at runtime.
 *                 port?: scalar|Param|null, // Defaults to null at runtime.
 *                 user?: scalar|Param|null, // Defaults to "root" at runtime.
 *                 password?: scalar|Param|null, // Defaults to null at runtime.
 *                 dbname_suffix?: scalar|Param|null, // Adds the given suffix to the configured database name, this option has no effects for the SQLite platform
 *                 application_name?: scalar|Param|null,
 *                 charset?: scalar|Param|null,
 *                 path?: scalar|Param|null,
 *                 memory?: bool|Param,
 *                 unix_socket?: scalar|Param|null, // The unix socket to use for MySQL
 *                 persistent?: bool|Param, // True to use as persistent connection for the ibm_db2 driver
 *                 protocol?: scalar|Param|null, // The protocol to use for the ibm_db2 driver (default to TCPIP if omitted)
 *                 service?: bool|Param, // True to use SERVICE_NAME as connection parameter instead of SID for Oracle
 *                 servicename?: scalar|Param|null, // Overrules dbname parameter if given and used as SERVICE_NAME or SID connection parameter for Oracle depending on the service parameter.
 *                 sessionMode?: scalar|Param|null, // The session mode to use for the oci8 driver
 *                 server?: scalar|Param|null, // The name of a running database server to connect to for SQL Anywhere.
 *                 default_dbname?: scalar|Param|null, // Override the default database (postgres) to connect to for PostgreSQL connection.
 *                 sslmode?: scalar|Param|null, // Determines whether or with what priority a SSL TCP/IP connection will be negotiated with the server for PostgreSQL.
 *                 sslrootcert?: scalar|Param|null, // The name of a file containing SSL certificate authority (CA) certificate(s). If the file exists, the server's certificate will be verified to be signed by one of these authorities.
 *                 sslcert?: scalar|Param|null, // The path to the SSL client certificate file for PostgreSQL.
 *                 sslkey?: scalar|Param|null, // The path to the SSL client key file for PostgreSQL.
 *                 sslcrl?: scalar|Param|null, // The file name of the SSL certificate revocation list for PostgreSQL.
 *                 pooled?: bool|Param, // True to use a pooled server with the oci8/pdo_oracle driver
 *                 MultipleActiveResultSets?: bool|Param, // Configuring MultipleActiveResultSets for the pdo_sqlsrv driver
 *                 instancename?: scalar|Param|null, // Optional parameter, complete whether to add the INSTANCE_NAME parameter in the connection. It is generally used to connect to an Oracle RAC server to select the name of a particular instance.
 *                 connectstring?: scalar|Param|null, // Complete Easy Connect connection descriptor, see https://docs.oracle.com/database/121/NETAG/naming.htm.When using this option, you will still need to provide the user and password parameters, but the other parameters will no longer be used. Note that when using this parameter, the getHost and getPort methods from Doctrine\DBAL\Connection will no longer function as expected.
 *                 ...<string, mixed>
 *             }>,
 *             ...<string, mixed>
 *         }>,
 *         ...<string, mixed>
 *     },
 *     orm?: array{
 *         default_entity_manager?: scalar|Param|null,
 *         enable_native_lazy_objects?: bool|Param, // Deprecated: The "enable_native_lazy_objects" option is deprecated and will be removed in DoctrineBundle 4.0, as native lazy objects are now always enabled. // Default: true
 *         controller_resolver?: bool|array{
 *             enabled?: bool|Param, // Default: true
 *             auto_mapping?: bool|Param, // Deprecated: The "doctrine.orm.controller_resolver.auto_mapping.auto_mapping" option is deprecated and will be removed in DoctrineBundle 4.0, as it only accepts `false` since 3.0. // Set to true to enable using route placeholders as lookup criteria when the primary key doesn't match the argument name // Default: false
 *             evict_cache?: bool|Param, // Set to true to fetch the entity from the database instead of using the cache, if any // Default: false
 *         },
 *         entity_managers?: array<string, array{ // Default: []
 *             query_cache_driver?: Param|string|array{
 *                 type?: scalar|Param|null, // Default: null
 *                 id?: scalar|Param|null,
 *                 pool?: scalar|Param|null,
 *             },
 *             metadata_cache_driver?: Param|string|array{
 *                 type?: scalar|Param|null, // Default: null
 *                 id?: scalar|Param|null,
 *                 pool?: scalar|Param|null,
 *             },
 *             result_cache_driver?: Param|string|array{
 *                 type?: scalar|Param|null, // Default: null
 *                 id?: scalar|Param|null,
 *                 pool?: scalar|Param|null,
 *             },
 *             entity_listeners?: array{
 *                 entities?: array<string, array{ // Default: []
 *                     listeners?: array<string, array{ // Default: []
 *                         events?: list<array{ // Default: []
 *                             type?: scalar|Param|null,
 *                             method?: scalar|Param|null, // Default: null
 *                         }>,
 *                     }>,
 *                 }>,
 *                 ...<string, mixed>
 *             },
 *             connection?: scalar|Param|null,
 *             class_metadata_factory_name?: scalar|Param|null, // Default: "Doctrine\\ORM\\Mapping\\ClassMetadataFactory"
 *             default_repository_class?: scalar|Param|null, // Default: "Doctrine\\ORM\\EntityRepository"
 *             auto_mapping?: scalar|Param|null, // Default: false
 *             naming_strategy?: scalar|Param|null, // Default: "doctrine.orm.naming_strategy.default"
 *             quote_strategy?: scalar|Param|null, // Default: "doctrine.orm.quote_strategy.default"
 *             typed_field_mapper?: scalar|Param|null, // Default: "doctrine.orm.typed_field_mapper.default"
 *             entity_listener_resolver?: scalar|Param|null, // Default: null
 *             fetch_mode_subselect_batch_size?: scalar|Param|null,
 *             repository_factory?: scalar|Param|null, // Default: "doctrine.orm.container_repository_factory"
 *             schema_ignore_classes?: list<scalar|Param|null>,
 *             validate_xml_mapping?: bool|Param, // Set to "true" to opt-in to the new mapping driver mode that was added in Doctrine ORM 2.14 and will be mandatory in ORM 3.0. See https://github.com/doctrine/orm/pull/6728. // Default: false
 *             second_level_cache?: array{
 *                 region_cache_driver?: Param|string|array{
 *                     type?: scalar|Param|null, // Default: null
 *                     id?: scalar|Param|null,
 *                     pool?: scalar|Param|null,
 *                 },
 *                 region_lock_lifetime?: scalar|Param|null, // Default: 60
 *                 log_enabled?: bool|Param, // Default: true
 *                 region_lifetime?: scalar|Param|null, // Default: 3600
 *                 enabled?: bool|Param, // Default: true
 *                 factory?: scalar|Param|null,
 *                 regions?: array<string, array{ // Default: []
 *                     cache_driver?: Param|string|array{
 *                         type?: scalar|Param|null, // Default: null
 *                         id?: scalar|Param|null,
 *                         pool?: scalar|Param|null,
 *                     },
 *                     lock_path?: scalar|Param|null, // Default: "%kernel.cache_dir%/doctrine/orm/slc/filelock"
 *                     lock_lifetime?: scalar|Param|null, // Default: 60
 *                     type?: scalar|Param|null, // Default: "default"
 *                     lifetime?: scalar|Param|null, // Default: null
 *                     service?: scalar|Param|null,
 *                     name?: scalar|Param|null,
 *                 }>,
 *                 loggers?: array<string, array{ // Default: []
 *                     name?: scalar|Param|null,
 *                     service?: scalar|Param|null,
 *                 }>,
 *             },
 *             hydrators?: array<string, scalar|Param|null>,
 *             mappings?: array<string, Param|bool|string|array{ // Default: []
 *                 mapping?: scalar|Param|null, // Default: true
 *                 type?: scalar|Param|null,
 *                 dir?: scalar|Param|null,
 *                 alias?: scalar|Param|null,
 *                 prefix?: scalar|Param|null,
 *                 is_bundle?: bool|Param,
 *             }>,
 *             dql?: array{
 *                 string_functions?: array<string, scalar|Param|null>,
 *                 numeric_functions?: array<string, scalar|Param|null>,
 *                 datetime_functions?: array<string, scalar|Param|null>,
 *             },
 *             filters?: array<string, Param|string|array{ // Default: []
 *                 class?: scalar|Param|null,
 *                 enabled?: bool|Param, // Default: false
 *                 parameters?: array<string, mixed>,
 *                 ...<string, mixed>
 *             }>,
 *             identity_generation_preferences?: array<string, scalar|Param|null>,
 *         }>,
 *         resolve_target_entities?: array<string, scalar|Param|null>,
 *         ...<string, mixed>
 *     },
 * }
 * @psalm-type DoctrineMigrationsConfig = array{
 *     enable_service_migrations?: bool|Param, // Whether to enable fetching migrations from the service container. // Default: false
 *     migrations_paths?: array<string, scalar|Param|null>,
 *     services?: array<string, scalar|Param|null>,
 *     factories?: array<string, scalar|Param|null>,
 *     storage?: array{ // Storage to use for migration status metadata.
 *         table_storage?: array{ // The default metadata storage, implemented as a table in the database.
 *             table_name?: scalar|Param|null, // Default: null
 *             version_column_name?: scalar|Param|null, // Default: null
 *             version_column_length?: scalar|Param|null, // Default: null
 *             executed_at_column_name?: scalar|Param|null, // Default: null
 *             execution_time_column_name?: scalar|Param|null, // Default: null
 *         },
 *     },
 *     migrations?: list<scalar|Param|null>,
 *     connection?: scalar|Param|null, // Connection name to use for the migrations database. // Default: null
 *     em?: scalar|Param|null, // Entity manager name to use for the migrations database (available when doctrine/orm is installed). // Default: null
 *     all_or_nothing?: scalar|Param|null, // Run all migrations in a transaction. // Default: false
 *     check_database_platform?: scalar|Param|null, // Adds an extra check in the generated migrations to allow execution only on the same platform as they were initially generated on. // Default: true
 *     custom_template?: scalar|Param|null, // Custom template path for generated migration classes. // Default: null
 *     organize_migrations?: scalar|Param|null, // Organize migrations mode. Possible values are: "BY_YEAR", "BY_YEAR_AND_MONTH", false // Default: false
 *     enable_profiler?: bool|Param, // Whether or not to enable the profiler collector to calculate and visualize migration status. This adds some queries overhead. // Default: false
 *     transactional?: bool|Param, // Whether or not to wrap migrations in a single transaction. // Default: true
 * }
 * @psalm-type NelmioApiDocConfig = array{
 *     type_info?: bool|Param, // Use the symfony/type-info component for determining types. // Default: true
 *     use_validation_groups?: bool|Param, // If true, `groups` passed to #[Model] attributes will be used to limit validation constraints // Default: false
 *     operation_id_generation?: \Nelmio\ApiDocBundle\Describer\OperationIdGeneration::ALWAYS_PREPEND|\Nelmio\ApiDocBundle\Describer\OperationIdGeneration::CONDITIONALLY_PREPEND|\Nelmio\ApiDocBundle\Describer\OperationIdGeneration::NO_PREPEND|"always_prepend"|"conditionally_prepend"|"no_prepend"|Param, // How to generate operation ids // Default: "always_prepend"
 *     cache?: array{
 *         pool?: scalar|Param|null, // define cache pool to use // Default: null
 *         item_id?: scalar|Param|null, // define cache item id // Default: null
 *     },
 *     documentation?: array<string, mixed>,
 *     media_types?: list<scalar|Param|null>,
 *     html_config?: array{ // UI configuration options
 *         assets_mode?: scalar|Param|null, // Default: "cdn"
 *         swagger_ui_config?: array<mixed>,
 *         redocly_config?: array<mixed>,
 *         scalar_config?: array<mixed>,
 *         stoplight_config?: array<mixed>,
 *     },
 *     areas?: array<string, array{ // Default: {"default":{"path_patterns":[],"host_patterns":[],"with_attribute":false,"documentation":[],"name_patterns":[],"disable_default_routes":false,"cache":[],"security":[]}}
 *         path_patterns?: list<scalar|Param|null>,
 *         host_patterns?: list<scalar|Param|null>,
 *         name_patterns?: list<scalar|Param|null>,
 *         security?: array<string, array{ // Default: []
 *             type?: scalar|Param|null,
 *             scheme?: scalar|Param|null,
 *             in?: scalar|Param|null,
 *             name?: scalar|Param|null,
 *             description?: scalar|Param|null,
 *             openIdConnectUrl?: scalar|Param|null,
 *             ...<string, mixed>
 *         }>,
 *         with_attribute?: bool|Param, // whether to filter by attributes // Default: false
 *         disable_default_routes?: bool|Param, // if set disables default routes without attributes // Default: false
 *         documentation?: array<string, mixed>,
 *         cache?: array{
 *             pool?: scalar|Param|null, // define cache pool to use // Default: null
 *             item_id?: scalar|Param|null, // define cache item id // Default: null
 *         },
 *     }>,
 *     models?: array{
 *         use_jms?: bool|Param, // Default: false
 *         names?: list<array{ // Default: []
 *             alias?: scalar|Param|null,
 *             type?: scalar|Param|null,
 *             groups?: mixed, // Default: null
 *             options?: mixed, // Default: null
 *             serializationContext?: list<mixed>,
 *             areas?: list<scalar|Param|null>,
 *         }>,
 *     },
 * }
 * @psalm-type NelmioCorsConfig = array{
 *     defaults?: array{
 *         allow_credentials?: bool|Param, // Default: false
 *         allow_origin?: list<scalar|Param|null>,
 *         allow_headers?: list<scalar|Param|null>,
 *         allow_methods?: list<scalar|Param|null>,
 *         allow_private_network?: bool|Param, // Default: false
 *         expose_headers?: list<scalar|Param|null>,
 *         max_age?: scalar|Param|null, // Default: 0
 *         hosts?: list<scalar|Param|null>,
 *         origin_regex?: bool|Param, // Default: false
 *         forced_allow_origin_value?: scalar|Param|null, // Default: null
 *         skip_same_as_origin?: bool|Param, // Default: true
 *     },
 *     paths?: array<string, array{ // Default: []
 *         allow_credentials?: bool|Param,
 *         allow_origin?: list<scalar|Param|null>,
 *         allow_headers?: list<scalar|Param|null>,
 *         allow_methods?: list<scalar|Param|null>,
 *         allow_private_network?: bool|Param,
 *         expose_headers?: list<scalar|Param|null>,
 *         max_age?: scalar|Param|null, // Default: 0
 *         hosts?: list<scalar|Param|null>,
 *         origin_regex?: bool|Param,
 *         forced_allow_origin_value?: scalar|Param|null, // Default: null
 *         skip_same_as_origin?: bool|Param,
 *     }>,
 * }
 * @psalm-type TwigConfig = array{
 *     form_themes?: list<scalar|Param|null>,
 *     globals?: array<string, array{ // Default: []
 *         id?: scalar|Param|null,
 *         type?: scalar|Param|null,
 *         value?: mixed,
 *         ...<string, mixed>
 *     }>,
 *     autoescape_service?: scalar|Param|null, // Default: null
 *     autoescape_service_method?: scalar|Param|null, // Default: null
 *     cache?: scalar|Param|null, // Default: true
 *     charset?: scalar|Param|null, // Default: "%kernel.charset%"
 *     debug?: bool|Param, // Default: "%kernel.debug%"
 *     strict_variables?: bool|Param, // Default: "%kernel.debug%"
 *     auto_reload?: scalar|Param|null,
 *     optimizations?: int|Param,
 *     default_path?: scalar|Param|null, // The default path used to load templates. // Default: "%kernel.project_dir%/templates"
 *     file_name_pattern?: Param|string|list<scalar|Param|null>,
 *     paths?: array<string, mixed>,
 *     date?: array{ // The default format options used by the date filter.
 *         format?: scalar|Param|null, // Default: "F j, Y H:i"
 *         interval_format?: scalar|Param|null, // Default: "%d days"
 *         timezone?: scalar|Param|null, // The timezone used when formatting dates, when set to null, the timezone returned by date_default_timezone_get() is used. // Default: null
 *     },
 *     number_format?: array{ // The default format options for the number_format filter.
 *         decimals?: int|Param, // Default: 0
 *         decimal_point?: scalar|Param|null, // Default: "."
 *         thousands_separator?: scalar|Param|null, // Default: ","
 *     },
 *     mailer?: array{
 *         html_to_text_converter?: scalar|Param|null, // A service implementing the "Symfony\Component\Mime\HtmlToTextConverter\HtmlToTextConverterInterface". // Default: null
 *     },
 * }
 * @psalm-type StimulusConfig = array{
 *     controller_paths?: list<scalar|Param|null>,
 *     controllers_json?: scalar|Param|null, // Default: "%kernel.project_dir%/assets/controllers.json"
 * }
 * @psalm-type SecurityConfig = array{
 *     access_denied_url?: scalar|Param|null, // Default: null
 *     session_fixation_strategy?: "none"|"migrate"|"invalidate"|Param, // Default: "migrate"
 *     expose_security_errors?: \Symfony\Component\Security\Http\Authentication\ExposeSecurityLevel::None|\Symfony\Component\Security\Http\Authentication\ExposeSecurityLevel::AccountStatus|\Symfony\Component\Security\Http\Authentication\ExposeSecurityLevel::All|Param, // Default: "none"
 *     erase_credentials?: bool|Param, // Deprecated: Setting the "security.erase_credentials.erase_credentials" configuration option is deprecated. It will be removed in Symfony 9.0, as the "eraseCredentials()" method was removed in Symfony 8.0. // Default: true
 *     access_decision_manager?: array{
 *         strategy?: "affirmative"|"consensus"|"unanimous"|"priority"|Param,
 *         service?: scalar|Param|null,
 *         strategy_service?: scalar|Param|null,
 *         allow_if_all_abstain?: bool|Param, // Default: false
 *         allow_if_equal_granted_denied?: bool|Param, // Default: true
 *     },
 *     password_hashers?: array<string, Param|string|array{ // Default: []
 *         algorithm?: scalar|Param|null,
 *         migrate_from?: Param|string|list<scalar|Param|null>,
 *         hash_algorithm?: scalar|Param|null, // Name of hashing algorithm for PBKDF2 (i.e. sha256, sha512, etc..) See hash_algos() for a list of supported algorithms. // Default: "sha512"
 *         key_length?: scalar|Param|null, // Default: 40
 *         ignore_case?: bool|Param, // Default: false
 *         encode_as_base64?: bool|Param, // Default: true
 *         iterations?: scalar|Param|null, // Default: 5000
 *         cost?: int|Param, // Default: null
 *         memory_cost?: scalar|Param|null, // Default: null
 *         time_cost?: scalar|Param|null, // Default: null
 *         id?: scalar|Param|null,
 *     }>,
 *     providers?: array<string, array{ // Default: []
 *         id?: scalar|Param|null,
 *         chain?: array{
 *             providers?: Param|string|list<scalar|Param|null>,
 *         },
 *         entity?: array{
 *             class?: scalar|Param|null, // The full entity class name of your user class.
 *             property?: scalar|Param|null, // Default: null
 *             manager_name?: scalar|Param|null, // Default: null
 *         },
 *         memory?: array{
 *             users?: array<string, array{ // Default: []
 *                 password?: scalar|Param|null, // Default: null
 *                 roles?: Param|string|list<scalar|Param|null>,
 *             }>,
 *         },
 *         ldap?: array{
 *             service?: scalar|Param|null,
 *             base_dn?: scalar|Param|null,
 *             search_dn?: scalar|Param|null, // Default: null
 *             search_password?: scalar|Param|null, // Default: null
 *             extra_fields?: list<scalar|Param|null>,
 *             default_roles?: Param|string|list<scalar|Param|null>,
 *             role_fetcher?: scalar|Param|null, // Default: null
 *             uid_key?: scalar|Param|null, // Default: "sAMAccountName"
 *             filter?: scalar|Param|null, // Default: "({uid_key}={user_identifier})"
 *             password_attribute?: scalar|Param|null, // Default: null
 *         },
 *         lexik_jwt?: array{
 *             class?: scalar|Param|null, // Default: "Lexik\\Bundle\\JWTAuthenticationBundle\\Security\\User\\JWTUser"
 *         },
 *     }>,
 *     firewalls?: array<string, array{ // Default: []
 *         pattern?: scalar|Param|null,
 *         host?: scalar|Param|null,
 *         methods?: Param|string|list<scalar|Param|null>,
 *         security?: bool|Param, // Default: true
 *         user_checker?: scalar|Param|null, // The UserChecker to use when authenticating users in this firewall. // Default: "security.user_checker"
 *         request_matcher?: scalar|Param|null,
 *         access_denied_url?: scalar|Param|null,
 *         access_denied_handler?: scalar|Param|null,
 *         entry_point?: scalar|Param|null, // An enabled authenticator name or a service id that implements "Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface".
 *         provider?: scalar|Param|null,
 *         stateless?: bool|Param, // Default: false
 *         lazy?: bool|Param, // Default: false
 *         context?: scalar|Param|null,
 *         logout?: array{
 *             enable_csrf?: bool|Param|null, // Default: null
 *             csrf_token_id?: scalar|Param|null, // Default: "logout"
 *             csrf_parameter?: scalar|Param|null, // Default: "_csrf_token"
 *             csrf_token_manager?: scalar|Param|null,
 *             path?: scalar|Param|null, // Default: "/logout"
 *             target?: scalar|Param|null, // Default: "/"
 *             invalidate_session?: bool|Param, // Default: true
 *             clear_site_data?: Param|string|list<"*"|"cache"|"cookies"|"storage"|"clientHints"|"executionContexts"|"prefetchCache"|"prerenderCache"|Param>,
 *             delete_cookies?: Param|string|array<string, array{ // Default: []
 *                 path?: scalar|Param|null, // Default: null
 *                 domain?: scalar|Param|null, // Default: null
 *                 secure?: scalar|Param|null, // Default: false
 *                 samesite?: scalar|Param|null, // Default: null
 *                 partitioned?: scalar|Param|null, // Default: false
 *             }>,
 *         },
 *         switch_user?: array{
 *             provider?: scalar|Param|null,
 *             parameter?: scalar|Param|null, // Default: "_switch_user"
 *             role?: scalar|Param|null, // Default: "ROLE_ALLOWED_TO_SWITCH"
 *             target_route?: scalar|Param|null, // Default: null
 *         },
 *         required_badges?: list<scalar|Param|null>,
 *         custom_authenticators?: list<scalar|Param|null>,
 *         login_throttling?: array{
 *             limiter?: scalar|Param|null, // A service id implementing "Symfony\Component\HttpFoundation\RateLimiter\RequestRateLimiterInterface".
 *             max_attempts?: int|Param, // Default: 5
 *             interval?: scalar|Param|null, // Default: "1 minute"
 *             lock_factory?: scalar|Param|null, // The service ID of the lock factory used by the login rate limiter ("auto" to use the default one when the Lock component is configured, or null to disable locking). // Default: "auto"
 *             cache_pool?: string|Param, // The cache pool to use for storing the limiter state // Default: "cache.rate_limiter"
 *             storage_service?: string|Param, // The service ID of a custom storage implementation, this precedes any configured "cache_pool" // Default: null
 *         },
 *         refresh_jwt?: array{
 *             check_path?: scalar|Param|null, // The path the refresh endpoint answers on, as a path or a route name. The authenticator only takes over requests matching it, so it has to be the route you defined for refreshing.
 *             provider?: scalar|Param|null,
 *             success_handler?: scalar|Param|null,
 *             failure_handler?: scalar|Param|null,
 *             invalidate_token_on_logout?: bool|Param, // When enabled, the refresh token will be invalided on logout. // Default: true
 *             ttl?: int|Param, // How long a refresh token issued on this firewall lasts, in seconds. Falls back to the bundle's "ttl". // Default: null
 *             ttl_update?: bool|Param|null, // Whether using a refresh token on this firewall starts its ttl over. Falls back to the bundle's "ttl_update". // Default: null
 *             token_parameter_name?: scalar|Param|null, // The request parameter carrying the refresh token on this firewall. Falls back to the bundle's "token_parameter_name". // Default: null
 *             single_use?: bool|Param|null, // Whether a refresh on this firewall replaces the token it used. Falls back to the bundle's "single_use". // Default: null
 *             single_use_ttl_update?: bool|Param|null, // Whether a token issued in place of a single use one on this firewall starts its ttl over. Falls back to the bundle's "single_use_ttl_update". // Default: null
 *             max_session_lifetime?: int|Param, // How long a chain of refreshes on this firewall may go on for, in seconds. Falls back to the bundle's "max_session_lifetime". // Default: null
 *             max_tokens_per_user?: int|Param, // How many refresh tokens a user may hold at once on this firewall. Falls back to the bundle's "max_tokens_per_user". // Default: null
 *             return_expiration?: bool|Param|null, // Whether the response on this firewall carries the token expiry. Falls back to the bundle's "return_expiration". // Default: null
 *             return_expiration_parameter_name?: scalar|Param|null, // The response field carrying the expiry on this firewall. Falls back to the bundle's "return_expiration_parameter_name". // Default: null
 *         },
 *         x509?: array{
 *             provider?: scalar|Param|null,
 *             user?: scalar|Param|null, // Default: "SSL_CLIENT_S_DN_Email"
 *             credentials?: scalar|Param|null, // Default: "SSL_CLIENT_S_DN"
 *             user_identifier?: scalar|Param|null, // Default: "emailAddress"
 *         },
 *         remote_user?: array{
 *             provider?: scalar|Param|null,
 *             user?: scalar|Param|null, // Default: "REMOTE_USER"
 *         },
 *         jwt?: array{
 *             provider?: scalar|Param|null, // Default: null
 *             authenticator?: scalar|Param|null, // Default: "lexik_jwt_authentication.security.jwt_authenticator"
 *         },
 *         login_link?: array{
 *             check_route?: scalar|Param|null, // Route that will validate the login link - e.g. "app_login_link_verify".
 *             check_post_only?: scalar|Param|null, // If true, only HTTP POST requests to "check_route" will be handled by the authenticator. // Default: false
 *             signature_properties?: list<scalar|Param|null>,
 *             lifetime?: int|Param, // The lifetime of the login link in seconds. // Default: 600
 *             max_uses?: int|Param, // Max number of times a login link can be used - null means unlimited within lifetime. // Default: null
 *             used_link_cache?: scalar|Param|null, // Cache service id used to expired links of max_uses is set.
 *             success_handler?: scalar|Param|null, // A service id that implements Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface.
 *             failure_handler?: scalar|Param|null, // A service id that implements Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface.
 *             provider?: scalar|Param|null, // The user provider to load users from.
 *             secret?: scalar|Param|null, // Default: "%kernel.secret%"
 *             always_use_default_target_path?: bool|Param, // Default: false
 *             default_target_path?: scalar|Param|null, // Default: "/"
 *             login_path?: scalar|Param|null, // Default: "/login"
 *             target_path_parameter?: scalar|Param|null, // Default: "_target_path"
 *             use_referer?: bool|Param, // Default: false
 *             failure_path?: scalar|Param|null, // Default: null
 *             failure_forward?: bool|Param, // Default: false
 *             failure_path_parameter?: scalar|Param|null, // Default: "_failure_path"
 *         },
 *         form_login?: array{
 *             provider?: scalar|Param|null,
 *             remember_me?: bool|Param, // Default: true
 *             success_handler?: scalar|Param|null,
 *             failure_handler?: scalar|Param|null,
 *             check_path?: scalar|Param|null, // Default: "/login_check"
 *             use_forward?: bool|Param, // Default: false
 *             login_path?: scalar|Param|null, // Default: "/login"
 *             username_parameter?: scalar|Param|null, // Default: "_username"
 *             password_parameter?: scalar|Param|null, // Default: "_password"
 *             csrf_parameter?: scalar|Param|null, // Default: "_csrf_token"
 *             csrf_token_id?: scalar|Param|null, // Default: "authenticate"
 *             enable_csrf?: bool|Param, // Default: false
 *             post_only?: bool|Param, // Default: true
 *             form_only?: bool|Param, // Default: false
 *             always_use_default_target_path?: bool|Param, // Default: false
 *             default_target_path?: scalar|Param|null, // Default: "/"
 *             target_path_parameter?: scalar|Param|null, // Default: "_target_path"
 *             use_referer?: bool|Param, // Default: false
 *             failure_path?: scalar|Param|null, // Default: null
 *             failure_forward?: bool|Param, // Default: false
 *             failure_path_parameter?: scalar|Param|null, // Default: "_failure_path"
 *         },
 *         form_login_ldap?: array{
 *             provider?: scalar|Param|null,
 *             remember_me?: bool|Param, // Default: true
 *             success_handler?: scalar|Param|null,
 *             failure_handler?: scalar|Param|null,
 *             check_path?: scalar|Param|null, // Default: "/login_check"
 *             use_forward?: bool|Param, // Default: false
 *             login_path?: scalar|Param|null, // Default: "/login"
 *             username_parameter?: scalar|Param|null, // Default: "_username"
 *             password_parameter?: scalar|Param|null, // Default: "_password"
 *             csrf_parameter?: scalar|Param|null, // Default: "_csrf_token"
 *             csrf_token_id?: scalar|Param|null, // Default: "authenticate"
 *             enable_csrf?: bool|Param, // Default: false
 *             post_only?: bool|Param, // Default: true
 *             form_only?: bool|Param, // Default: false
 *             always_use_default_target_path?: bool|Param, // Default: false
 *             default_target_path?: scalar|Param|null, // Default: "/"
 *             target_path_parameter?: scalar|Param|null, // Default: "_target_path"
 *             use_referer?: bool|Param, // Default: false
 *             failure_path?: scalar|Param|null, // Default: null
 *             failure_forward?: bool|Param, // Default: false
 *             failure_path_parameter?: scalar|Param|null, // Default: "_failure_path"
 *             service?: scalar|Param|null, // Default: "ldap"
 *             dn_string?: scalar|Param|null, // Default: "{user_identifier}"
 *             query_string?: scalar|Param|null,
 *             search_dn?: scalar|Param|null, // Default: ""
 *             search_password?: scalar|Param|null, // Default: ""
 *         },
 *         json_login?: array{
 *             provider?: scalar|Param|null,
 *             remember_me?: bool|Param, // Default: true
 *             success_handler?: scalar|Param|null,
 *             failure_handler?: scalar|Param|null,
 *             check_path?: scalar|Param|null, // Default: "/login_check"
 *             use_forward?: bool|Param, // Default: false
 *             login_path?: scalar|Param|null, // Default: "/login"
 *             username_path?: scalar|Param|null, // Default: "username"
 *             password_path?: scalar|Param|null, // Default: "password"
 *         },
 *         json_login_ldap?: array{
 *             provider?: scalar|Param|null,
 *             remember_me?: bool|Param, // Default: true
 *             success_handler?: scalar|Param|null,
 *             failure_handler?: scalar|Param|null,
 *             check_path?: scalar|Param|null, // Default: "/login_check"
 *             use_forward?: bool|Param, // Default: false
 *             login_path?: scalar|Param|null, // Default: "/login"
 *             username_path?: scalar|Param|null, // Default: "username"
 *             password_path?: scalar|Param|null, // Default: "password"
 *             service?: scalar|Param|null, // Default: "ldap"
 *             dn_string?: scalar|Param|null, // Default: "{user_identifier}"
 *             query_string?: scalar|Param|null,
 *             search_dn?: scalar|Param|null, // Default: ""
 *             search_password?: scalar|Param|null, // Default: ""
 *         },
 *         access_token?: array{
 *             provider?: scalar|Param|null,
 *             remember_me?: bool|Param, // Default: true
 *             success_handler?: scalar|Param|null,
 *             failure_handler?: scalar|Param|null,
 *             realm?: scalar|Param|null, // Default: null
 *             token_extractors?: Param|string|list<scalar|Param|null>,
 *             token_handler?: Param|string|array{
 *                 id?: scalar|Param|null,
 *                 oidc_user_info?: Param|string|array{
 *                     base_uri?: scalar|Param|null, // Base URI of the userinfo endpoint on the OIDC server, or the OIDC server URI to use the discovery (require "discovery" to be configured). The latter must end with a slash when it has a path, as the discovery path is resolved against it as a relative URL.
 *                     discovery?: array{ // Enable the OIDC discovery.
 *                         cache?: array{
 *                             id?: scalar|Param|null, // Cache service id to use to cache the OIDC discovery configuration.
 *                         },
 *                     },
 *                     claim?: scalar|Param|null, // Claim which contains the user identifier (e.g. sub, email, etc.). // Default: "sub"
 *                     client?: scalar|Param|null, // HttpClient service id to use to call the OIDC server.
 *                 },
 *                 oidc?: array{
 *                     discovery?: array{ // Enable the OIDC discovery.
 *                         base_uri?: Param|string|list<scalar|Param|null>,
 *                         cache?: array{
 *                             id?: scalar|Param|null, // Cache service id to use to cache the OIDC discovery configuration.
 *                         },
 *                         enforce_key_usage_verification?: bool|Param, // When enabled (default), only keys explicitly designated for signature (via "use":"sig" or a "key_ops" entry containing "sign"/"verify") are accepted. When disabled, keys without any usage designation are also accepted; keys explicitly restricted to encryption are still rejected. // Default: true
 *                     },
 *                     claim?: scalar|Param|null, // Claim which contains the user identifier (e.g.: sub, email..). // Default: "sub"
 *                     audience?: scalar|Param|null, // Audience set in the token, for validation purpose.
 *                     issuers?: list<scalar|Param|null>,
 *                     algorithms?: list<scalar|Param|null>,
 *                     keyset?: scalar|Param|null, // JSON-encoded JWKSet used to sign the token (must contain a list of valid public keys).
 *                     encryption?: bool|array{
 *                         enabled?: bool|Param, // Default: false
 *                         enforce?: bool|Param, // When enabled, the token shall be encrypted. // Default: false
 *                         algorithms?: list<scalar|Param|null>,
 *                         keyset?: scalar|Param|null, // JSON-encoded JWKSet used to decrypt the token (must contain a list of valid private keys).
 *                     },
 *                 },
 *                 cas?: array{
 *                     validation_url?: scalar|Param|null, // CAS server validation URL
 *                     prefix?: scalar|Param|null, // CAS prefix // Default: "cas"
 *                     http_client?: scalar|Param|null, // HTTP Client service // Default: null
 *                 },
 *                 oauth2?: scalar|Param|null,
 *             },
 *         },
 *         http_basic?: array{
 *             provider?: scalar|Param|null,
 *             realm?: scalar|Param|null, // Default: "Secured Area"
 *         },
 *         http_basic_ldap?: array{
 *             provider?: scalar|Param|null,
 *             realm?: scalar|Param|null, // Default: "Secured Area"
 *             service?: scalar|Param|null, // Default: "ldap"
 *             dn_string?: scalar|Param|null, // Default: "{user_identifier}"
 *             query_string?: scalar|Param|null,
 *             search_dn?: scalar|Param|null, // Default: ""
 *             search_password?: scalar|Param|null, // Default: ""
 *         },
 *         remember_me?: array{
 *             secret?: scalar|Param|null, // Default: "%kernel.secret%"
 *             service?: scalar|Param|null,
 *             user_providers?: Param|string|list<scalar|Param|null>,
 *             catch_exceptions?: bool|Param, // Default: true
 *             signature_properties?: list<scalar|Param|null>,
 *             token_provider?: Param|string|array{
 *                 service?: scalar|Param|null, // The service ID of a custom remember-me token provider.
 *                 doctrine?: bool|array{
 *                     enabled?: bool|Param, // Default: false
 *                     connection?: scalar|Param|null, // Default: null
 *                 },
 *             },
 *             token_verifier?: scalar|Param|null, // The service ID of a custom rememberme token verifier.
 *             name?: scalar|Param|null, // Default: "REMEMBERME"
 *             lifetime?: int|Param, // Default: 31536000
 *             path?: scalar|Param|null, // Default: "/"
 *             domain?: scalar|Param|null, // Default: null
 *             secure?: true|false|"auto"|Param, // Defaults to the value of "framework.session.cookie_secure", or to "auto".
 *             httponly?: bool|Param, // Default: true
 *             samesite?: null|"lax"|"strict"|"none"|Param, // Defaults to the value of "framework.session.cookie_samesite", or to "lax".
 *             always_remember_me?: bool|Param, // Default: false
 *             remember_me_parameter?: scalar|Param|null, // Default: "_remember_me"
 *         },
 *     }>,
 *     access_control?: list<array{ // Default: []
 *         request_matcher?: scalar|Param|null, // Default: null
 *         requires_channel?: scalar|Param|null, // Default: null
 *         path?: scalar|Param|null, // Use the urldecoded format. // Default: null
 *         host?: scalar|Param|null, // Default: null
 *         port?: int|Param, // Default: null
 *         ips?: Param|string|list<scalar|Param|null>,
 *         attributes?: array<string, scalar|Param|null>,
 *         route?: scalar|Param|null, // Default: null
 *         methods?: Param|string|list<scalar|Param|null>,
 *         allow_if?: scalar|Param|null, // Default: null
 *         roles?: Param|string|list<scalar|Param|null>,
 *     }>,
 *     role_hierarchy?: array<string, Param|string|list<scalar|Param|null>>,
 * }
 * @psalm-type SonataTwigConfig = array{
 *     form_type?: "standard"|"horizontal"|Param, // Style used in the forms, some of the widgets need to be wrapped in a special div element depending on this style. // Default: "standard"
 *     flashmessage?: array<string, array{ // Default: []
 *         css_class?: scalar|Param|null,
 *         types?: list<scalar|Param|null>,
 *     }>,
 * }
 * @psalm-type SonataFormConfig = array{
 *     form_type?: scalar|Param|null, // Must be one of standard, horizontal // Default: "standard"
 * }
 * @psalm-type SonataExporterConfig = array{
 *     exporter?: array{
 *         default_writers?: list<scalar|Param|null>,
 *     },
 *     writers?: array{
 *         csv?: array{
 *             filename?: scalar|Param|null, // path to the output file // Default: "php://output"
 *             delimiter?: scalar|Param|null, // delimits csv values // Default: ","
 *             enclosure?: scalar|Param|null, // will be used when a value contains the delimiter // Default: "\""
 *             escape?: scalar|Param|null, // will be used when a value contains the enclosure // Default: "\\"
 *             show_headers?: bool|Param, // add column names as the first line // Default: true
 *             with_bom?: bool|Param, // include the byte order mark // Default: false
 *         },
 *         json?: array{
 *             filename?: scalar|Param|null, // path to the output file // Default: "php://output"
 *         },
 *         xls?: array{
 *             filename?: scalar|Param|null, // path to the output file // Default: "php://output"
 *             show_headers?: bool|Param, // add column names as the first line // Default: true
 *         },
 *         xlsx?: array{
 *             filename?: scalar|Param|null, // path to the output file // Default: "php://output"
 *             show_headers?: bool|Param, // add column names as the first line // Default: true
 *             show_filters?: bool|Param, // add filters in the first line // Default: true
 *         },
 *         xml?: array{
 *             filename?: scalar|Param|null, // path to the output file // Default: "php://output"
 *             show_headers?: bool|Param, // add column names as the first line // Default: true
 *             main_element?: scalar|Param|null, // name of the wrapping element // Default: "datas"
 *             child_element?: scalar|Param|null, // name of elements corresponding to rows // Default: "data"
 *         },
 *     },
 * }
 * @psalm-type SonataBlockConfig = array{
 *     profiler?: array{
 *         enabled?: scalar|Param|null, // Default: "%kernel.debug%"
 *         template?: scalar|Param|null, // Default: "@SonataBlock/Profiler/block.html.twig"
 *     },
 *     default_contexts?: list<scalar|Param|null>,
 *     context_manager?: scalar|Param|null, // Default: "sonata.block.context_manager.default"
 *     http_cache?: bool|Param, // Deprecated: The "http_cache" option is deprecated and not doing anything anymore since sonata-project/block-bundle 5.0. It will be removed in 6.0. // Default: false
 *     templates?: array{
 *         block_base?: scalar|Param|null, // Default: null
 *         block_container?: scalar|Param|null, // Default: null
 *     },
 *     container?: array{ // block container configuration
 *         types?: list<scalar|Param|null>,
 *         templates?: list<scalar|Param|null>,
 *     },
 *     blocks?: array<string, array{ // Default: []
 *         contexts?: list<scalar|Param|null>,
 *         templates?: list<array{ // Default: []
 *             name?: scalar|Param|null,
 *             template?: scalar|Param|null,
 *         }>,
 *         settings?: array<string, scalar|Param|null>,
 *         exception?: array{
 *             filter?: scalar|Param|null, // Default: null
 *             renderer?: scalar|Param|null, // Default: null
 *         },
 *     }>,
 *     blocks_by_class?: array<string, array{ // Default: []
 *         settings?: array<string, scalar|Param|null>,
 *     }>,
 *     exception?: array{
 *         default?: array{
 *             filter?: scalar|Param|null, // Default: "debug_only"
 *             renderer?: scalar|Param|null, // Default: "throw"
 *         },
 *         filters?: array<string, scalar|Param|null>,
 *         renderers?: array<string, scalar|Param|null>,
 *     },
 * }
 * @psalm-type KnpMenuConfig = array{
 *     providers?: array{
 *         builder_alias?: bool|Param, // Default: true
 *     },
 *     twig?: array{
 *         template?: scalar|Param|null, // Default: "@KnpMenu/menu.html.twig"
 *     },
 *     route_voter?: bool|Param, // Default: true
 *     default_renderer?: scalar|Param|null, // Default: "twig"
 * }
 * @psalm-type SonataAdminConfig = array{
 *     security?: array{
 *         handler?: scalar|Param|null, // Default: "sonata.admin.security.handler.noop"
 *         information?: array<string, Param|string|list<scalar|Param|null>>,
 *         admin_permissions?: list<scalar|Param|null>,
 *         role_admin?: scalar|Param|null, // Role which will see the top nav bar and dropdown groups regardless of its configuration // Default: "ROLE_SONATA_ADMIN"
 *         role_super_admin?: scalar|Param|null, // Role which will perform all admin actions, see dashboard, menu and search groups regardless of its configuration // Default: "ROLE_SUPER_ADMIN"
 *         object_permissions?: list<scalar|Param|null>,
 *         acl_user_manager?: scalar|Param|null, // Default: null
 *     },
 *     title?: scalar|Param|null, // Default: "Sonata Admin"
 *     title_logo?: scalar|Param|null, // Default: "bundles/sonataadmin/images/logo_title.png"
 *     search?: bool|Param, // Enable/disable the search form in the sidebar // Default: true
 *     global_search?: array{
 *         empty_boxes?: scalar|Param|null, // Perhaps one of the three options: show, fade, hide. // Default: "show"
 *         admin_route?: scalar|Param|null, // Change the default route used to generate the link to the object // Default: "show"
 *     },
 *     default_controller?: scalar|Param|null, // Name of the controller class to be used as a default in admin definitions // Default: "sonata.admin.controller.crud"
 *     breadcrumbs?: array{
 *         child_admin_route?: scalar|Param|null, // Change the default route used to generate the link to the parent object, when in a child admin // Default: "show"
 *     },
 *     options?: array{
 *         html5_validate?: bool|Param, // Default: true
 *         sort_admins?: bool|Param, // Auto order groups and admins by label or id // Default: false
 *         confirm_exit?: bool|Param, // Default: true
 *         js_debug?: bool|Param, // Default: false
 *         skin?: "skin-black"|"skin-black-light"|"skin-blue"|"skin-blue-light"|"skin-green"|"skin-green-light"|"skin-purple"|"skin-purple-light"|"skin-red"|"skin-red-light"|"skin-yellow"|"skin-yellow-light"|Param, // Default: "skin-black"
 *         use_select2?: bool|Param, // Default: true
 *         use_icheck?: bool|Param, // Default: true
 *         use_bootlint?: bool|Param, // Default: false
 *         use_stickyforms?: bool|Param, // Default: true
 *         pager_links?: int|Param, // Default: null
 *         form_type?: scalar|Param|null, // Default: "standard"
 *         default_admin_route?: scalar|Param|null, // Name of the admin route to be used as a default to generate the link to the object // Default: "show"
 *         default_group?: scalar|Param|null, // Group used for admin services if one isn't provided. // Default: "default"
 *         default_label_catalogue?: scalar|Param|null, // Deprecated: The "default_label_catalogue" node is deprecated, use "default_translation_domain" instead. // Label Catalogue used for admin services if one isn't provided. // Default: "SonataAdminBundle"
 *         default_translation_domain?: scalar|Param|null, // Translation domain used for admin services if one isn't provided. // Default: null
 *         default_icon?: scalar|Param|null, // Icon used for admin services if one isn't provided. // Default: "fas fa-folder"
 *         dropdown_number_groups_per_colums?: int|Param, // Default: 2
 *         logo_content?: "text"|"icon"|"all"|Param, // Default: "all"
 *         list_action_button_content?: "text"|"icon"|"all"|Param, // Default: "all"
 *         lock_protection?: bool|Param, // Enable locking when editing an object, if the corresponding object manager supports it. // Default: false
 *         mosaic_background?: scalar|Param|null, // Background used in mosaic view // Default: "bundles/sonataadmin/images/default_mosaic_image.png"
 *     },
 *     dashboard?: array{
 *         groups?: array<string, array{ // Default: []
 *             label?: scalar|Param|null,
 *             translation_domain?: scalar|Param|null,
 *             label_catalogue?: scalar|Param|null, // Deprecated: The "label_catalogue" node is deprecated, use "translation_domain" instead.
 *             icon?: scalar|Param|null,
 *             on_top?: scalar|Param|null, // Show menu item in side dashboard menu without treeview // Default: false
 *             keep_open?: scalar|Param|null, // Keep menu group always open // Default: false
 *             provider?: scalar|Param|null,
 *             items?: list<array{ // Default: []
 *                 admin?: scalar|Param|null,
 *                 label?: scalar|Param|null,
 *                 route?: scalar|Param|null,
 *                 roles?: list<scalar|Param|null>,
 *                 route_params?: list<scalar|Param|null>,
 *                 route_absolute?: bool|Param, // Whether the generated url should be absolute // Default: false
 *             }>,
 *             item_adds?: list<scalar|Param|null>,
 *             roles?: list<scalar|Param|null>,
 *         }>,
 *         blocks?: list<array{ // Default: [{"position":"left","settings":[],"type":"sonata.admin.block.admin_list","roles":[]}]
 *             type?: scalar|Param|null,
 *             roles?: list<scalar|Param|null>,
 *             settings?: array<string, mixed>,
 *             position?: scalar|Param|null, // Default: "right"
 *             class?: scalar|Param|null, // Default: "col-md-4"
 *         }>,
 *     },
 *     default_admin_services?: array{
 *         model_manager?: scalar|Param|null, // Default: null
 *         data_source?: scalar|Param|null, // Default: null
 *         field_description_factory?: scalar|Param|null, // Default: null
 *         form_contractor?: scalar|Param|null, // Default: null
 *         show_builder?: scalar|Param|null, // Default: null
 *         list_builder?: scalar|Param|null, // Default: null
 *         datagrid_builder?: scalar|Param|null, // Default: null
 *         translator?: scalar|Param|null, // Default: null
 *         configuration_pool?: scalar|Param|null, // Default: null
 *         route_generator?: scalar|Param|null, // Default: null
 *         security_handler?: scalar|Param|null, // Default: null
 *         menu_factory?: scalar|Param|null, // Default: null
 *         route_builder?: scalar|Param|null, // Default: null
 *         label_translator_strategy?: scalar|Param|null, // Default: null
 *         pager_type?: scalar|Param|null, // Default: null
 *     },
 *     templates?: array{
 *         user_block?: scalar|Param|null, // Default: "@SonataAdmin/Core/user_block.html.twig"
 *         add_block?: scalar|Param|null, // Default: "@SonataAdmin/Core/add_block.html.twig"
 *         layout?: scalar|Param|null, // Default: "@SonataAdmin/standard_layout.html.twig"
 *         ajax?: scalar|Param|null, // Default: "@SonataAdmin/ajax_layout.html.twig"
 *         dashboard?: scalar|Param|null, // Default: "@SonataAdmin/Core/dashboard.html.twig"
 *         search?: scalar|Param|null, // Default: "@SonataAdmin/Core/search.html.twig"
 *         list?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/list.html.twig"
 *         filter?: scalar|Param|null, // Default: "@SonataAdmin/Form/filter_admin_fields.html.twig"
 *         show?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/show.html.twig"
 *         show_compare?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/show_compare.html.twig"
 *         edit?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/edit.html.twig"
 *         preview?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/preview.html.twig"
 *         history?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/history.html.twig"
 *         acl?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/acl.html.twig"
 *         history_revision_timestamp?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/history_revision_timestamp.html.twig"
 *         action?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/action.html.twig"
 *         select?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/list__select.html.twig"
 *         list_block?: scalar|Param|null, // Default: "@SonataAdmin/Block/block_admin_list.html.twig"
 *         search_result_block?: scalar|Param|null, // Default: "@SonataAdmin/Block/block_search_result.html.twig"
 *         short_object_description?: scalar|Param|null, // Default: "@SonataAdmin/Helper/short-object-description.html.twig"
 *         delete?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/delete.html.twig"
 *         batch?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/list__batch.html.twig"
 *         batch_confirmation?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/batch_confirmation.html.twig"
 *         inner_list_row?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/list_inner_row.html.twig"
 *         outer_list_rows_mosaic?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/list_outer_rows_mosaic.html.twig"
 *         outer_list_rows_list?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/list_outer_rows_list.html.twig"
 *         outer_list_rows_tree?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/list_outer_rows_tree.html.twig"
 *         base_list_field?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/base_list_field.html.twig"
 *         pager_links?: scalar|Param|null, // Default: "@SonataAdmin/Pager/links.html.twig"
 *         pager_results?: scalar|Param|null, // Default: "@SonataAdmin/Pager/results.html.twig"
 *         tab_menu_template?: scalar|Param|null, // Default: "@SonataAdmin/Core/tab_menu_template.html.twig"
 *         knp_menu_template?: scalar|Param|null, // Default: "@SonataAdmin/Menu/sonata_menu.html.twig"
 *         action_create?: scalar|Param|null, // Default: "@SonataAdmin/CRUD/dashboard__action_create.html.twig"
 *         button_acl?: scalar|Param|null, // Default: "@SonataAdmin/Button/acl_button.html.twig"
 *         button_create?: scalar|Param|null, // Default: "@SonataAdmin/Button/create_button.html.twig"
 *         button_edit?: scalar|Param|null, // Default: "@SonataAdmin/Button/edit_button.html.twig"
 *         button_history?: scalar|Param|null, // Default: "@SonataAdmin/Button/history_button.html.twig"
 *         button_list?: scalar|Param|null, // Default: "@SonataAdmin/Button/list_button.html.twig"
 *         button_show?: scalar|Param|null, // Default: "@SonataAdmin/Button/show_button.html.twig"
 *         form_theme?: list<scalar|Param|null>,
 *         filter_theme?: list<scalar|Param|null>,
 *     },
 *     assets?: array{
 *         stylesheets?: list<array{ // Default: [{"path":"bundles/sonataadmin/app.css","package_name":"sonata_admin"},{"path":"bundles/sonataform/app.css","package_name":"sonata_admin"}]
 *             path?: scalar|Param|null,
 *             package_name?: scalar|Param|null, // Default: "sonata_admin"
 *         }>,
 *         extra_stylesheets?: list<array{ // Default: []
 *             path?: scalar|Param|null,
 *             package_name?: scalar|Param|null, // Default: "sonata_admin"
 *         }>,
 *         remove_stylesheets?: list<array{ // Default: []
 *             path?: scalar|Param|null,
 *             package_name?: scalar|Param|null, // Default: "sonata_admin"
 *         }>,
 *         javascripts?: list<array{ // Default: [{"path":"bundles/sonataadmin/app.js","package_name":"sonata_admin"},{"path":"bundles/sonataform/app.js","package_name":"sonata_admin"}]
 *             path?: scalar|Param|null,
 *             package_name?: scalar|Param|null, // Default: "sonata_admin"
 *         }>,
 *         extra_javascripts?: list<array{ // Default: []
 *             path?: scalar|Param|null,
 *             package_name?: scalar|Param|null, // Default: "sonata_admin"
 *         }>,
 *         remove_javascripts?: list<array{ // Default: []
 *             path?: scalar|Param|null,
 *             package_name?: scalar|Param|null, // Default: "sonata_admin"
 *         }>,
 *     },
 *     extensions?: array<string, array{ // Default: []
 *         global?: bool|Param, // Default: false
 *         admins?: list<scalar|Param|null>,
 *         excludes?: list<scalar|Param|null>,
 *         implements?: list<scalar|Param|null>,
 *         extends?: list<scalar|Param|null>,
 *         instanceof?: list<scalar|Param|null>,
 *         uses?: list<scalar|Param|null>,
 *         admin_implements?: list<scalar|Param|null>,
 *         admin_extends?: list<scalar|Param|null>,
 *         admin_instanceof?: list<scalar|Param|null>,
 *         admin_uses?: list<scalar|Param|null>,
 *         priority?: int|Param, // Positive or negative integer. The higher the priority, the earlier it’s executed. // Default: 0
 *     }>,
 *     persist_filters?: scalar|Param|null, // Default: false
 *     filter_persister?: scalar|Param|null, // Default: "sonata.admin.filter_persister.session"
 *     show_mosaic_button?: bool|Param, // Show mosaic button on all admin screens // Default: true
 * }
 * @psalm-type SonataDoctrineOrmAdminConfig = array{
 *     entity_manager?: scalar|Param|null, // Default: null
 *     audit?: array{
 *         force?: bool|Param, // Default: true
 *     },
 *     templates?: array{
 *         types?: array{
 *             list?: array<string, scalar|Param|null>,
 *             show?: array<string, scalar|Param|null>,
 *         },
 *     },
 * }
 * @psalm-type SonataTranslationConfig = array{
 *     locales?: list<scalar|Param|null>,
 *     default_locale?: scalar|Param|null, // The frontend locale that is used by default. // Default: "en"
 *     default_filter_mode?: "gedmo"|"knplabs"|Param, // The filter mode that is used by default. // Default: "gedmo"
 *     gedmo?: bool|array{
 *         enabled?: bool|Param, // Default: false
 *         implements?: list<scalar|Param|null>,
 *         instanceof?: list<scalar|Param|null>,
 *         translatable_listener_service?: scalar|Param|null, // Custom translatable listener service name when using gedmo/doctrine-extensions
 *     },
 *     knplabs?: bool|array{
 *         enabled?: bool|Param, // Default: false
 *         implements?: list<scalar|Param|null>,
 *         instanceof?: list<scalar|Param|null>,
 *     },
 *     locale_switcher?: bool|Param, // Enable the global locale switcher services. // Default: false
 * }
 * @psalm-type StofDoctrineExtensionsConfig = array{
 *     orm?: array<string, array{ // Default: []
 *         translatable?: scalar|Param|null, // Default: false
 *         timestampable?: scalar|Param|null, // Default: false
 *         blameable?: scalar|Param|null, // Default: false
 *         sluggable?: scalar|Param|null, // Default: false
 *         tree?: scalar|Param|null, // Default: false
 *         loggable?: scalar|Param|null, // Default: false
 *         ip_traceable?: scalar|Param|null, // Default: false
 *         sortable?: scalar|Param|null, // Default: false
 *         softdeleteable?: scalar|Param|null, // Default: false
 *         uploadable?: scalar|Param|null, // Default: false
 *         reference_integrity?: scalar|Param|null, // Default: false
 *     }>,
 *     mongodb?: array<string, array{ // Default: []
 *         translatable?: scalar|Param|null, // Default: false
 *         timestampable?: scalar|Param|null, // Default: false
 *         blameable?: scalar|Param|null, // Default: false
 *         sluggable?: scalar|Param|null, // Default: false
 *         tree?: scalar|Param|null, // Default: false
 *         loggable?: scalar|Param|null, // Default: false
 *         ip_traceable?: scalar|Param|null, // Default: false
 *         sortable?: scalar|Param|null, // Default: false
 *         softdeleteable?: scalar|Param|null, // Default: false
 *         uploadable?: scalar|Param|null, // Default: false
 *         reference_integrity?: scalar|Param|null, // Default: false
 *     }>,
 *     class?: array{
 *         translatable?: scalar|Param|null, // Default: "Gedmo\\Translatable\\TranslatableListener"
 *         timestampable?: scalar|Param|null, // Default: "Gedmo\\Timestampable\\TimestampableListener"
 *         blameable?: scalar|Param|null, // Default: "Gedmo\\Blameable\\BlameableListener"
 *         sluggable?: scalar|Param|null, // Default: "Gedmo\\Sluggable\\SluggableListener"
 *         tree?: scalar|Param|null, // Default: "Gedmo\\Tree\\TreeListener"
 *         loggable?: scalar|Param|null, // Default: "Gedmo\\Loggable\\LoggableListener"
 *         sortable?: scalar|Param|null, // Default: "Gedmo\\Sortable\\SortableListener"
 *         softdeleteable?: scalar|Param|null, // Default: "Gedmo\\SoftDeleteable\\SoftDeleteableListener"
 *         uploadable?: scalar|Param|null, // Default: "Gedmo\\Uploadable\\UploadableListener"
 *         reference_integrity?: scalar|Param|null, // Default: "Gedmo\\ReferenceIntegrity\\ReferenceIntegrityListener"
 *     },
 *     softdeleteable?: array{
 *         handle_post_flush_event?: bool|Param, // Default: false
 *     },
 *     uploadable?: array{
 *         default_file_path?: scalar|Param|null, // Default: null
 *         mime_type_guesser_class?: scalar|Param|null, // Default: "Stof\\DoctrineExtensionsBundle\\Uploadable\\MimeTypeGuesserAdapter"
 *         default_file_info_class?: scalar|Param|null, // Default: "Stof\\DoctrineExtensionsBundle\\Uploadable\\UploadedFileInfo"
 *         validate_writable_directory?: bool|Param, // Default: true
 *     },
 *     default_locale?: scalar|Param|null, // Default: "en"
 *     translation_fallback?: bool|Param, // Default: false
 *     persist_default_translation?: bool|Param, // Default: false
 *     skip_translation_on_load?: bool|Param, // Default: false
 *     metadata_cache_pool?: scalar|Param|null, // Default: null
 * }
 * @psalm-type MonologConfig = array{
 *     use_microseconds?: scalar|Param|null, // Default: true
 *     timezone?: string|Param, // The timezone used for the timestamp of every log record (e.g. "UTC" or "Europe/Paris"). Defaults to the PHP default timezone. // Default: null
 *     channels?: list<scalar|Param|null>,
 *     handlers?: array<string, array{ // Default: []
 *         type?: scalar|Param|null,
 *         id?: scalar|Param|null,
 *         enabled?: bool|Param, // Default: true
 *         priority?: scalar|Param|null, // Default: 0
 *         level?: scalar|Param|null, // Default: "DEBUG"
 *         bubble?: bool|Param, // Default: true
 *         interactive_only?: bool|Param, // Default: false
 *         app_name?: scalar|Param|null, // Default: null
 *         include_stacktraces?: bool|Param, // Default: false
 *         base_path?: scalar|Param|null, // Default: null
 *         process_psr_3_messages?: array{
 *             enabled?: bool|Param|null, // Default: null
 *             date_format?: scalar|Param|null,
 *             remove_used_context_fields?: bool|Param,
 *             ...<string, mixed>
 *         },
 *         path?: scalar|Param|null, // Default: "%kernel.logs_dir%/%kernel.environment%.log"
 *         file_permission?: scalar|Param|null, // Default: null
 *         use_locking?: bool|Param, // Default: false
 *         filename_format?: scalar|Param|null, // Default: "{filename}-{date}"
 *         date_format?: scalar|Param|null, // Default: "Y-m-d"
 *         ident?: scalar|Param|null, // Default: "php"
 *         logopts?: scalar|Param|null, // Default: 1
 *         facility?: scalar|Param|null, // Default: "user"
 *         max_files?: scalar|Param|null, // Default: 0
 *         action_level?: scalar|Param|null, // Default: "WARNING"
 *         activation_strategy?: scalar|Param|null, // Default: null
 *         stop_buffering?: bool|Param, // Default: true
 *         passthru_level?: scalar|Param|null, // Default: null
 *         excluded_http_codes?: list<array{ // Default: []
 *             code?: scalar|Param|null,
 *             urls?: list<scalar|Param|null>,
 *         }>,
 *         accepted_levels?: list<scalar|Param|null>,
 *         min_level?: scalar|Param|null, // Default: "DEBUG"
 *         max_level?: scalar|Param|null, // Default: "EMERGENCY"
 *         buffer_size?: scalar|Param|null, // Default: 0
 *         flush_on_overflow?: bool|Param, // Default: false
 *         handler?: scalar|Param|null,
 *         url?: scalar|Param|null,
 *         exchange?: scalar|Param|null,
 *         exchange_name?: scalar|Param|null, // Default: "log"
 *         channel?: scalar|Param|null, // Default: null
 *         bot_name?: scalar|Param|null, // Default: "Monolog"
 *         use_attachment?: scalar|Param|null, // Default: true
 *         use_short_attachment?: scalar|Param|null, // Default: false
 *         include_extra?: scalar|Param|null, // Default: false
 *         icon_emoji?: scalar|Param|null, // Default: null
 *         webhook_url?: scalar|Param|null,
 *         exclude_fields?: list<scalar|Param|null>,
 *         token?: scalar|Param|null,
 *         region?: scalar|Param|null,
 *         source?: scalar|Param|null,
 *         use_ssl?: bool|Param, // Default: true
 *         user?: mixed,
 *         title?: scalar|Param|null, // Default: null
 *         host?: scalar|Param|null, // Default: null
 *         port?: scalar|Param|null, // Default: 514
 *         rfc?: scalar|Param|null, // Default: 1
 *         config?: list<scalar|Param|null>,
 *         members?: list<scalar|Param|null>,
 *         connection_string?: scalar|Param|null,
 *         timeout?: scalar|Param|null,
 *         time?: scalar|Param|null, // Default: 60
 *         deduplication_level?: scalar|Param|null, // Default: 400
 *         store?: scalar|Param|null, // Default: null
 *         connection_timeout?: scalar|Param|null,
 *         persistent?: bool|Param,
 *         message_type?: scalar|Param|null, // Default: 0
 *         expand_newlines?: bool|Param, // Default: false
 *         parse_mode?: scalar|Param|null, // Default: null
 *         disable_webpage_preview?: bool|Param|null, // Default: null
 *         disable_notification?: bool|Param|null, // Default: null
 *         split_long_messages?: bool|Param, // Default: false
 *         delay_between_messages?: bool|Param, // Default: false
 *         topic?: int|Param, // Default: null
 *         factor?: int|Param, // Default: 1
 *         tags?: Param|string|list<scalar|Param|null>,
 *         console_formatter_options?: mixed, // Default: []
 *         formatter?: scalar|Param|null,
 *         nested?: bool|Param, // Default: false
 *         publisher?: Param|string|array{
 *             id?: scalar|Param|null,
 *             hostname?: scalar|Param|null,
 *             port?: scalar|Param|null, // Default: 12201
 *             chunk_size?: scalar|Param|null, // Default: 1420
 *             encoder?: "json"|"compressed_json"|Param,
 *         },
 *         mongodb?: Param|string|array{
 *             id?: scalar|Param|null, // ID of a MongoDB\Client service
 *             uri?: scalar|Param|null,
 *             username?: scalar|Param|null,
 *             password?: scalar|Param|null,
 *             database?: scalar|Param|null, // Default: "monolog"
 *             collection?: scalar|Param|null, // Default: "logs"
 *         },
 *         elasticsearch?: Param|string|array{
 *             id?: scalar|Param|null,
 *             hosts?: list<scalar|Param|null>,
 *             host?: scalar|Param|null,
 *             port?: scalar|Param|null, // Default: 9200
 *             transport?: scalar|Param|null, // Default: "Http"
 *             user?: scalar|Param|null, // Default: null
 *             password?: scalar|Param|null, // Default: null
 *         },
 *         index?: scalar|Param|null, // Default: "monolog"
 *         document_type?: scalar|Param|null, // Default: "logs"
 *         ignore_error?: scalar|Param|null, // Default: false
 *         redis?: Param|string|array{
 *             id?: scalar|Param|null,
 *             host?: scalar|Param|null,
 *             password?: scalar|Param|null, // Default: null
 *             port?: scalar|Param|null, // Default: 6379
 *             database?: scalar|Param|null, // Default: 0
 *             key_name?: scalar|Param|null, // Default: "monolog_redis"
 *         },
 *         predis?: Param|string|array{ // Deprecated: The "predis" option is deprecated and ignored, use the "redis" option to configure the Predis client.
 *             id?: scalar|Param|null,
 *             host?: scalar|Param|null,
 *         },
 *         from_email?: scalar|Param|null,
 *         to_email?: Param|string|list<scalar|Param|null>,
 *         subject?: scalar|Param|null,
 *         content_type?: scalar|Param|null, // Default: null
 *         headers?: list<scalar|Param|null>,
 *         parameters?: list<scalar|Param|null>,
 *         mailer?: scalar|Param|null, // Default: null
 *         email_prototype?: Param|string|array{
 *             id?: scalar|Param|null,
 *             method?: scalar|Param|null, // Default: null
 *         },
 *         verbosity_levels?: array{
 *             VERBOSITY_QUIET?: scalar|Param|null, // Default: "ERROR"
 *             VERBOSITY_NORMAL?: scalar|Param|null, // Default: "WARNING"
 *             VERBOSITY_VERBOSE?: scalar|Param|null, // Default: "NOTICE"
 *             VERBOSITY_VERY_VERBOSE?: scalar|Param|null, // Default: "INFO"
 *             VERBOSITY_DEBUG?: scalar|Param|null, // Default: "DEBUG"
 *         },
 *         channels?: Param|string|array{
 *             type?: scalar|Param|null,
 *             elements?: list<scalar|Param|null>,
 *             ...<string, mixed>
 *         },
 *     }>,
 * }
 * @psalm-type WebProfilerConfig = array{
 *     toolbar?: bool|array{ // Profiler toolbar configuration
 *         enabled?: bool|Param, // Default: false
 *         ajax_replace?: bool|Param, // Replace toolbar on AJAX requests // Default: false
 *     },
 *     intercept_redirects?: bool|Param, // Default: false
 *     excluded_ajax_paths?: scalar|Param|null, // Default: "^/((index|app(_[\\w]+)?)\\.php/)?_wdt"
 * }
 * @psalm-type FosCkEditorConfig = array{
 *     enable?: bool|Param, // Default: true
 *     async?: bool|Param, // Default: false
 *     auto_inline?: bool|Param, // Default: true
 *     inline?: bool|Param, // Default: false
 *     autoload?: bool|Param, // Default: true
 *     jquery?: bool|Param, // Default: false
 *     require_js?: bool|Param, // Default: false
 *     input_sync?: bool|Param, // Default: false
 *     base_path?: scalar|Param|null, // Default: "bundles/fosckeditor/"
 *     js_path?: scalar|Param|null, // Default: "bundles/fosckeditor/ckeditor.js"
 *     jquery_path?: scalar|Param|null, // Default: "bundles/fosckeditor/adapters/jquery.js"
 *     default_config?: scalar|Param|null, // Default: null
 *     configs?: array<string, array<string, mixed>>,
 *     plugins?: array<string, array{ // Default: []
 *         path?: scalar|Param|null,
 *         filename?: scalar|Param|null,
 *     }>,
 *     styles?: array<string, list<array{ // Default: []
 *         name?: scalar|Param|null,
 *         type?: scalar|Param|null,
 *         widget?: scalar|Param|null,
 *         element?: mixed,
 *         styles?: array<string, scalar|Param|null>,
 *         attributes?: array<string, scalar|Param|null>,
 *     }>>,
 *     templates?: array<string, array{ // Default: []
 *         imagesPath?: scalar|Param|null,
 *         templates?: list<array{ // Default: []
 *             title?: scalar|Param|null,
 *             image?: scalar|Param|null,
 *             description?: scalar|Param|null,
 *             html?: scalar|Param|null,
 *             template?: scalar|Param|null,
 *             template_parameters?: array<string, scalar|Param|null>,
 *         }>,
 *     }>,
 *     filebrowsers?: array<string, scalar|Param|null>,
 *     toolbars?: array{
 *         configs?: array<string, list<mixed>>,
 *         items?: array<string, list<mixed>>,
 *     },
 * }
 * @psalm-type FmElfinderConfig = array{
 *     configuration_provider?: scalar|Param|null, // Default: "fm_elfinder.configurator.default"
 *     assets_path?: scalar|Param|null, // Default: "assets"
 *     loader?: scalar|Param|null, // Default: "fm_elfinder.loader.default"
 *     instances?: array<string, array{ // Default: []
 *         locale?: scalar|Param|null, // Default: null
 *         cors_support?: bool|Param, // Default: false
 *         editor?: scalar|Param|null, // Default: "simple"
 *         editor_template?: scalar|Param|null, // Default: null
 *         multiple?: bool|Param, // Default: false
 *         callback_function?: scalar|Param|null, // Default: null
 *         fullscreen?: bool|Param, // Default: true
 *         multi_home_folder?: bool|Param, // Default: false
 *         folder_separator?: scalar|Param|null, // Default: ""
 *         theme?: scalar|Param|null, // Default: "smoothness"
 *         tinymce_popup_path?: scalar|Param|null, // Default: ""
 *         relative_path?: bool|Param, // Default: true
 *         path_prefix?: scalar|Param|null, // Default: "/"
 *         where_is_multi?: list<scalar|Param|null>,
 *         visible_mime_types?: list<scalar|Param|null>,
 *         connector?: array{
 *             debug?: bool|Param, // Default: false
 *             binds?: array<string, array<string, mixed>>,
 *             plugins?: array<string, array<string, mixed>>,
 *             roots?: array<string, array{ // Default: []
 *                 driver?: scalar|Param|null,
 *                 volume_id?: int|Param, // Default: 0
 *                 path?: scalar|Param|null, // Default: ""
 *                 autoload?: bool|Param, // Default: false
 *                 phash?: scalar|Param|null, // Default: ""
 *                 trash_hash?: scalar|Param|null, // Default: ""
 *                 locale?: scalar|Param|null, // Default: ""
 *                 i18n_folder_name?: bool|Param, // Default: false
 *                 mime_detect?: scalar|Param|null, // Default: "auto"
 *                 mimefile?: scalar|Param|null, // Default: ""
 *                 security_voter?: scalar|Param|null, // Default: ""
 *                 start_path?: scalar|Param|null, // Default: ""
 *                 encoding?: scalar|Param|null, // Default: "UTF-8"
 *                 url?: scalar|Param|null, // Default: ""
 *                 alias?: scalar|Param|null, // Default: ""
 *                 img_lib?: scalar|Param|null, // Default: "auto"
 *                 tmb_path?: scalar|Param|null, // Default: ".tmb"
 *                 tmb_path_mode?: scalar|Param|null, // Default: 511
 *                 tmb_url?: scalar|Param|null, // Default: ""
 *                 tmb_size?: int|Param, // Default: 48
 *                 tmb_crop?: bool|Param, // Default: true
 *                 tmb_bg_color?: scalar|Param|null, // Default: "#ffffff"
 *                 quarantine?: scalar|Param|null, // Default: null
 *                 copy_overwrite?: bool|Param, // Default: true
 *                 copy_join?: bool|Param, // Default: true
 *                 copy_from?: bool|Param, // Default: true
 *                 copy_to?: bool|Param, // Default: true
 *                 upload_overwrite?: bool|Param, // Default: true
 *                 fileMode?: scalar|Param|null, // Default: 420
 *                 upload_allow?: list<scalar|Param|null>,
 *                 upload_deny?: list<scalar|Param|null>,
 *                 upload_order?: list<scalar|Param|null>,
 *                 upload_max_size?: scalar|Param|null, // Default: 0
 *                 upload_max_conn?: int|Param, // Default: 3
 *                 defaults?: array<string, bool|Param>,
 *                 attributes?: list<array{ // Default: []
 *                     pattern?: scalar|Param|null,
 *                     read?: scalar|Param|null, // Default: true
 *                     write?: scalar|Param|null, // Default: true
 *                     locked?: scalar|Param|null, // Default: false
 *                     hidden?: scalar|Param|null, // Default: false
 *                 }>,
 *                 accepted_name?: scalar|Param|null, // Default: "/^\\w[\\w\\s\\.\\%\\-]*$/u"
 *                 show_hidden?: bool|Param, // Default: false
 *                 disabled_commands?: list<scalar|Param|null>,
 *                 tree_deep?: int|Param, // Default: 0
 *                 check_subfolders?: int|Param, // Default: 1
 *                 separator?: scalar|Param|null, // Default: "/"
 *                 date_format?: scalar|Param|null, // Default: "j M Y H:i"
 *                 time_format?: scalar|Param|null, // Default: "H:i"
 *                 archive_mimes?: list<scalar|Param|null>,
 *                 archivers?: bool|array{
 *                     enabled?: bool|Param, // Default: false
 *                     create?: list<array{ // Default: []
 *                         cmd?: scalar|Param|null,
 *                         argc?: scalar|Param|null,
 *                         ext?: scalar|Param|null,
 *                     }>,
 *                     extract?: list<array{ // Default: []
 *                         cmd?: scalar|Param|null,
 *                         argc?: scalar|Param|null,
 *                         ext?: scalar|Param|null,
 *                     }>,
 *                 },
 *                 flysystem?: bool|array{
 *                     enabled?: bool|Param, // Default: false
 *                     filesystem?: scalar|Param|null, // Default: ""
 *                     type?: scalar|Param|null, // Default: ""
 *                     adapter_service?: scalar|Param|null, // Default: ""
 *                     options?: array{
 *                         local?: bool|array{
 *                             enabled?: bool|Param, // Default: false
 *                             path?: scalar|Param|null, // Default: ""
 *                         },
 *                         ftp?: bool|array{
 *                             enabled?: bool|Param, // Default: false
 *                             host?: scalar|Param|null, // Default: ""
 *                             username?: scalar|Param|null, // Default: ""
 *                             password?: scalar|Param|null, // Default: ""
 *                             port?: int|Param, // Default: 21
 *                             passive?: bool|Param, // Default: true
 *                             ssl?: bool|Param, // Default: true
 *                             timeout?: int|Param, // Default: 30
 *                             root?: scalar|Param|null, // Default: "/"
 *                             directoryPerm?: int|Param, // Default: 484
 *                         },
 *                         sftp?: bool|array{
 *                             enabled?: bool|Param, // Default: false
 *                             host?: scalar|Param|null, // Default: ""
 *                             username?: scalar|Param|null, // Default: ""
 *                             password?: scalar|Param|null, // Default: ""
 *                             port?: int|Param, // Default: 21
 *                             privateKey?: scalar|Param|null, // Default: ""
 *                             timeout?: int|Param, // Default: 10
 *                             root?: scalar|Param|null, // Default: "/"
 *                             permPublic?: int|Param, // Default: null
 *                             permPrivate?: int|Param, // Default: null
 *                             directoryPerm?: int|Param, // Default: null
 *                         },
 *                         aws_s3_v3?: bool|array{
 *                             enabled?: bool|Param, // Default: false
 *                             key?: scalar|Param|null, // Default: ""
 *                             secret?: scalar|Param|null, // Default: ""
 *                             region?: scalar|Param|null, // Default: ""
 *                             version?: scalar|Param|null, // Default: ""
 *                             bucket_name?: scalar|Param|null, // Default: ""
 *                             optional_prefix?: scalar|Param|null, // Default: ""
 *                             endpoint?: scalar|Param|null, // Default: null
 *                             use_path_style_endpoint?: bool|Param, // Default: false
 *                             use_aws_shared_config_files?: bool|Param, // Default: true
 *                             options?: list<mixed>,
 *                         },
 *                         dropbox?: bool|array{
 *                             enabled?: bool|Param, // Default: false
 *                             app?: scalar|Param|null, // Default: ""
 *                             token?: scalar|Param|null, // Default: ""
 *                         },
 *                     },
 *                 },
 *                 glide_url?: scalar|Param|null, // Default: ""
 *                 glide_key?: scalar|Param|null, // Default: ""
 *                 plugins?: array<string, array<string, mixed>>,
 *                 driver_options?: array<string, array<string, mixed>>,
 *                 dropbox2_settings?: bool|array{
 *                     enabled?: bool|Param, // Default: false
 *                     app_key?: scalar|Param|null,
 *                     app_secret?: scalar|Param|null,
 *                     access_token?: scalar|Param|null,
 *                     aliasFormat?: scalar|Param|null, // Default: "%s@Dropbox"
 *                     path?: scalar|Param|null, // Default: "/"
 *                     separator?: scalar|Param|null, // Default: "/"
 *                     acceptedName?: scalar|Param|null, // Default: "%s@Dropbox"
 *                     rootCssClass?: scalar|Param|null, // Default: "elfinder-navbar-root-dropbox"
 *                     publishPermission?: array{
 *                         requested_visibility?: scalar|Param|null, // Default: "public"
 *                     },
 *                     getThumbSize?: scalar|Param|null, // Default: "medium"
 *                 },
 *                 box_settings?: bool|array{
 *                     enabled?: bool|Param, // Default: false
 *                     client_id?: scalar|Param|null,
 *                     client_secret?: scalar|Param|null,
 *                     accessToken?: scalar|Param|null,
 *                     root?: scalar|Param|null, // Default: "Box.com"
 *                     path?: scalar|Param|null, // Default: "/"
 *                     separator?: scalar|Param|null, // Default: "/"
 *                     tmbPath?: scalar|Param|null, // Default: ""
 *                     tmbURL?: scalar|Param|null, // Default: ""
 *                     tmpPath?: scalar|Param|null, // Default: ""
 *                     acceptedName?: scalar|Param|null, // Default: "#^[^/\\?*:|\"<>]*[^./\\?*:|\"<>]$#"
 *                     rootCssClass?: scalar|Param|null, // Default: "elfinder-navbar-root-box"
 *                 },
 *                 onedrive_settings?: bool|array{
 *                     enabled?: bool|Param, // Default: false
 *                     client_id?: scalar|Param|null,
 *                     client_secret?: scalar|Param|null,
 *                     accessToken?: scalar|Param|null,
 *                     root?: scalar|Param|null, // Default: "OneDrive.com"
 *                     OneDriveApiClient?: scalar|Param|null, // Default: ""
 *                     path?: scalar|Param|null, // Default: "/"
 *                     separator?: scalar|Param|null, // Default: "/"
 *                     tmbPath?: scalar|Param|null, // Default: ""
 *                     tmbURL?: scalar|Param|null, // Default: ""
 *                     tmpPath?: scalar|Param|null, // Default: ""
 *                     acceptedName?: scalar|Param|null, // Default: "#^[^/\\?*:|\"<>]*[^./\\?*:|\"<>]$#"
 *                     rootCssClass?: scalar|Param|null, // Default: "elfinder-navbar-root-onedrive"
 *                     useApiThumbnail?: bool|Param, // Default: true
 *                 },
 *                 ftp_settings?: bool|array{
 *                     enabled?: bool|Param, // Default: false
 *                     host?: scalar|Param|null,
 *                     user?: scalar|Param|null,
 *                     password?: scalar|Param|null,
 *                     path?: scalar|Param|null,
 *                 },
 *                 mysql_settings?: bool|array{
 *                     enabled?: bool|Param, // Default: false
 *                     host?: scalar|Param|null,
 *                     user?: scalar|Param|null,
 *                     pass?: scalar|Param|null,
 *                     db?: scalar|Param|null,
 *                     port?: scalar|Param|null, // Default: null
 *                     socket?: scalar|Param|null, // Default: null
 *                     files_table?: scalar|Param|null, // Default: "elfinder_file"
 *                     tmbPath?: scalar|Param|null, // Default: ""
 *                     tmpPath?: scalar|Param|null, // Default: ""
 *                     rootCssClass?: scalar|Param|null, // Default: "elfinder-navbar-root-sql"
 *                     noSessionCache?: scalar|Param|null, // Default: "hasdirs"
 *                 },
 *             }>,
 *         },
 *     }>,
 * }
 * @psalm-type FlysystemConfig = array{
 *     storages?: array<string, array{ // Default: []
 *         adapter?: scalar|Param|null, // DEPRECATED: Use the new config format instead (e.g. "local:" instead of "adapter: local")
 *         options?: list<mixed>,
 *         asyncaws?: array{
 *             client?: scalar|Param|null, // The AsyncAws S3 client service name
 *             bucket?: scalar|Param|null, // The name of the AWS S3 bucket
 *             prefix?: scalar|Param|null, // Optional path prefix to prepend to all object keys // Default: ""
 *         },
 *         aws?: array{
 *             client?: scalar|Param|null, // The AWS S3 client service name
 *             bucket?: scalar|Param|null, // The name of the AWS S3 bucket
 *             prefix?: scalar|Param|null, // Optional path prefix to prepend to all object keys // Default: ""
 *             options?: list<mixed>,
 *             streamReads?: bool|Param, // Whether to use streaming for file reads // Default: true
 *         },
 *         azure?: array{
 *             client?: scalar|Param|null, // The Azure Blob Storage client service name
 *             container?: scalar|Param|null, // The name of the Azure Blob Storage container
 *             prefix?: scalar|Param|null, // Optional path prefix to prepend to all blob names // Default: ""
 *         },
 *         ftp?: array{
 *             host?: scalar|Param|null, // FTP host
 *             username?: scalar|Param|null, // FTP username
 *             password?: scalar|Param|null, // FTP password
 *             port?: int|Param, // FTP port number // Default: 21
 *             root?: scalar|Param|null, // FTP root directory // Default: ""
 *             passive?: bool|Param, // Use passive mode // Default: true
 *             ssl?: bool|Param, // Use SSL/TLS encryption // Default: false
 *             timeout?: int|Param, // Connection timeout in seconds // Default: 90
 *             ignore_passive_address?: scalar|Param|null, // Ignore passive address // Default: null
 *             utf8?: bool|Param, // Enable UTF8 mode // Default: false
 *             transfer_mode?: scalar|Param|null, // Transfer mode (FTP_ASCII or FTP_BINARY constant on ftp extension) // Default: null
 *             system_type?: null|"windows"|"unix"|Param, // FTP system type // Default: null
 *             timestamps_on_unix_listings_enabled?: bool|Param, // Enable timestamps on Unix listings // Default: false
 *             recurse_manually?: bool|Param, // Recurse directories manually // Default: true
 *             use_raw_list_options?: bool|Param|null, // Use raw list options // Default: null
 *             connectivityChecker?: scalar|Param|null, // Connectivity checker service name // Default: null
 *             permissions?: array{ // Unix permissions configuration for files and directories
 *                 file?: array{ // File permissions
 *                     public?: int|Param, // Public file permissions // Default: 420
 *                     private?: int|Param, // Private file permissions // Default: 384
 *                 },
 *                 dir?: array{ // Directory permissions
 *                     public?: int|Param, // Public directory permissions // Default: 493
 *                     private?: int|Param, // Private directory permissions // Default: 448
 *                 },
 *             },
 *         },
 *         gcloud?: array{
 *             client?: scalar|Param|null, // The Google Cloud Storage client service name
 *             bucket?: scalar|Param|null, // The name of the Google Cloud Storage bucket
 *             prefix?: scalar|Param|null, // Optional path prefix to prepend to all object keys // Default: ""
 *             visibility_handler?: scalar|Param|null, // Optional visibility handler service name // Default: null
 *             streamReads?: bool|Param, // Whether to use streaming for file reads // Default: false
 *         },
 *         gridfs?: array{
 *             bucket?: scalar|Param|null, // GridFS bucket service name (if using an existing bucket service) // Default: null
 *             prefix?: scalar|Param|null, // Optional path prefix to prepend to all file names // Default: ""
 *             database?: scalar|Param|null, // MongoDB database name // Default: null
 *             doctrine_connection?: scalar|Param|null, // Doctrine MongoDB connection name (mutually exclusive with mongodb_uri)
 *             mongodb_uri?: scalar|Param|null, // MongoDB connection URI (mutually exclusive with doctrine_connection)
 *             mongodb_uri_options?: list<mixed>,
 *             mongodb_driver_options?: list<mixed>,
 *         },
 *         lazy?: array{ // Lazy adapter for runtime storage selection
 *             source?: scalar|Param|null, // The service name of the storage to use at runtime
 *         },
 *         local?: array{
 *             directory?: scalar|Param|null, // Directory path for local storage
 *             lock?: int|Param, // Lock flags for file operations // Default: 0
 *             skip_links?: bool|Param, // Whether to skip symbolic links // Default: false
 *             lazy_root_creation?: bool|Param, // Whether to create the root directory lazily // Default: false
 *             permissions?: array{ // Unix permissions configuration for files and directories
 *                 file?: array{ // File permissions
 *                     public?: int|Param, // Public file permissions // Default: 420
 *                     private?: int|Param, // Private file permissions // Default: 384
 *                 },
 *                 dir?: array{ // Directory permissions
 *                     public?: int|Param, // Public directory permissions // Default: 493
 *                     private?: int|Param, // Private directory permissions // Default: 448
 *                 },
 *             },
 *         },
 *         memory?: array<mixed>,
 *         sftp?: array{
 *             host?: scalar|Param|null, // SFTP host
 *             username?: scalar|Param|null, // SFTP username
 *             password?: scalar|Param|null, // SFTP password (optional if using private key) // Default: null
 *             privateKey?: scalar|Param|null, // Path to private key file or private key content // Default: null
 *             passphrase?: scalar|Param|null, // Private key passphrase // Default: null
 *             port?: int|Param, // SFTP port number // Default: 22
 *             timeout?: int|Param, // Connection timeout in seconds // Default: 90
 *             hostFingerprint?: scalar|Param|null, // Host fingerprint for verification // Default: null
 *             connectivityChecker?: scalar|Param|null, // Connectivity checker service name // Default: null
 *             preferredAlgorithms?: list<mixed>,
 *             root?: scalar|Param|null, // SFTP root directory // Default: ""
 *             permissions?: array{ // Unix permissions configuration for files and directories
 *                 file?: array{ // File permissions
 *                     public?: int|Param, // Public file permissions // Default: 420
 *                     private?: int|Param, // Private file permissions // Default: 384
 *                 },
 *                 dir?: array{ // Directory permissions
 *                     public?: int|Param, // Public directory permissions // Default: 493
 *                     private?: int|Param, // Private directory permissions // Default: 448
 *                 },
 *             },
 *         },
 *         webdav?: array{
 *             client?: scalar|Param|null, // The WebDAV client service name
 *             prefix?: scalar|Param|null, // Optional path prefix to prepend to all paths // Default: ""
 *             visibility_handling?: "throw"|"ignore"|Param, // How to handle visibility operations // Default: "throw"
 *             manual_copy?: bool|Param, // Whether to handle copy operations manually // Default: false
 *             manual_move?: bool|Param, // Whether to handle move operations manually // Default: false
 *         },
 *         bunnycdn?: array{
 *             client?: scalar|Param|null, // The BunnyCDN client service name
 *             pull_zone?: scalar|Param|null, // The BunnyCDN pull zone name // Default: ""
 *         },
 *         service?: scalar|Param|null, // Reference to a custom adapter service (alternative to registered adapter types)
 *         visibility?: scalar|Param|null, // Default visibility for files // Default: null
 *         directory_visibility?: scalar|Param|null, // Default visibility for directories // Default: null
 *         retain_visibility?: scalar|Param|null, // Keeps the original file visibility (public/private) when copying or moving. // Default: null
 *         case_sensitive?: bool|Param, // Deprecated: The "case_sensitive" option is deprecated and will be removed in 4.0. // Default: true
 *         disable_asserts?: bool|Param, // Deprecated: The "disable_asserts" option is deprecated and will be removed in 4.0. // Default: false
 *         public_url?: list<scalar|Param|null>,
 *         path_normalizer?: scalar|Param|null, // Path normalizer service name (should implement League\Flysystem\PathNormalizer) // Default: null
 *         public_url_generator?: scalar|Param|null, // For adapter that do not provide public URLs or override adapter capabilities and public_url option, a public URL generator service name can be configured in the main Filesystem configuration (should implement League\Flysystem\UrlGeneration\PublicUrlGenerator) // Default: null
 *         temporary_url_generator?: scalar|Param|null, // For adapter that do not provide public URLs or override adapter capabilities, a temporary URL generator service name can be configured in the main Filesystem configuration (should implement League\Flysystem\UrlGeneration\TemporaryUrlGenerator) // Default: null
 *         read_only?: bool|Param, // Converts a file system to read-only // Default: false
 *     }>,
 * }
 * @psalm-type VichUploaderConfig = array{
 *     default_filename_attribute_suffix?: scalar|Param|null, // Default: "_name"
 *     db_driver?: scalar|Param|null,
 *     storage?: scalar|Param|null, // Default: "file_system"
 *     use_flysystem_to_resolve_uri?: bool|Param, // Default: false
 *     twig?: scalar|Param|null, // twig requires templating // Default: true
 *     form?: scalar|Param|null, // Default: true
 *     metadata?: array{
 *         cache?: scalar|Param|null, // Default: "file"
 *         type?: scalar|Param|null, // Default: "attribute"
 *         file_cache?: array{
 *             dir?: scalar|Param|null, // Default: "%kernel.cache_dir%/vich_uploader"
 *         },
 *         auto_detection?: bool|Param, // Default: true
 *         directories?: list<array{ // Default: []
 *             path?: scalar|Param|null,
 *             namespace_prefix?: scalar|Param|null, // Default: ""
 *         }>,
 *     },
 *     mappings?: array<string, array{ // Default: []
 *         uri_prefix?: scalar|Param|null, // Default: "/uploads"
 *         upload_destination?: scalar|Param|null, // Default: null
 *         namer?: Param|string|array{
 *             service?: scalar|Param|null, // Default: null
 *             options?: mixed, // Default: null
 *         },
 *         directory_namer?: Param|string|array{
 *             service?: scalar|Param|null, // Default: null
 *             options?: mixed, // Default: null
 *         },
 *         delete_on_remove?: scalar|Param|null, // Default: true
 *         erase_fields?: scalar|Param|null, // Default: true
 *         delete_on_update?: scalar|Param|null, // Default: true
 *         inject_on_load?: scalar|Param|null, // Default: false
 *         namer_keep_extension?: scalar|Param|null, // Default: false
 *         db_driver?: scalar|Param|null, // Default: null
 *     }>,
 * }
 * @psalm-type MakerConfig = array{
 *     root_namespace?: scalar|Param|null, // Default: "App"
 *     generate_final_classes?: bool|Param, // Default: true
 *     generate_final_entities?: bool|Param, // Default: false
 * }
 * @psalm-type LexikJwtAuthenticationConfig = array{
 *     public_key?: scalar|Param|null, // The key used to sign tokens (useless for HMAC). If not set, the key will be automatically computed from the secret key. // Default: null
 *     additional_public_keys?: list<scalar|Param|null>,
 *     secret_key?: scalar|Param|null, // The key used to sign tokens. It can be a raw secret (for HMAC), a raw RSA/ECDSA key or the path to a file itself being plaintext or PEM. // Default: null
 *     pass_phrase?: scalar|Param|null, // The key passphrase (useless for HMAC) // Default: ""
 *     token_ttl?: scalar|Param|null, // Default: 3600
 *     allow_no_expiration?: bool|Param, // Allow tokens without "exp" claim (i.e. indefinitely valid, no lifetime) to be considered valid. Caution: usage of this should be rare. // Default: false
 *     clock_skew?: scalar|Param|null, // Default: 0
 *     encoder?: array{
 *         service?: scalar|Param|null, // Default: "lexik_jwt_authentication.encoder.lcobucci"
 *         signature_algorithm?: scalar|Param|null, // Default: "RS256"
 *     },
 *     user_id_claim?: scalar|Param|null, // Default: "username"
 *     token_extractors?: array{
 *         authorization_header?: bool|array{
 *             enabled?: bool|Param, // Default: true
 *             prefix?: scalar|Param|null, // Default: "Bearer"
 *             name?: scalar|Param|null, // Default: "Authorization"
 *         },
 *         cookie?: bool|array{
 *             enabled?: bool|Param, // Default: false
 *             name?: scalar|Param|null, // Default: "BEARER"
 *         },
 *         query_parameter?: bool|array{
 *             enabled?: bool|Param, // Default: false
 *             name?: scalar|Param|null, // Default: "bearer"
 *         },
 *         split_cookie?: bool|array{
 *             enabled?: bool|Param, // Default: false
 *             cookies?: list<scalar|Param|null>,
 *         },
 *     },
 *     remove_token_from_body_when_cookies_used?: scalar|Param|null, // Default: true
 *     set_cookies?: array<string, array{ // Default: []
 *         lifetime?: scalar|Param|null, // The cookie lifetime. If null, the "token_ttl" option value will be used // Default: null
 *         samesite?: "none"|"lax"|"strict"|Param, // Default: "lax"
 *         path?: scalar|Param|null, // Default: "/"
 *         domain?: scalar|Param|null, // Default: null
 *         secure?: scalar|Param|null, // Default: true
 *         httpOnly?: scalar|Param|null, // Default: true
 *         partitioned?: scalar|Param|null, // Default: false
 *         split?: list<scalar|Param|null>,
 *     }>,
 *     api_platform?: bool|array{ // API Platform compatibility: add check_path in OpenAPI documentation.
 *         enabled?: bool|Param, // Default: false
 *         check_path?: scalar|Param|null, // The login check path to add in OpenAPI. // Default: null
 *         username_path?: scalar|Param|null, // The path to the username in the JSON body. // Default: null
 *         password_path?: scalar|Param|null, // The path to the password in the JSON body. // Default: null
 *     },
 *     access_token_issuance?: bool|array{
 *         enabled?: bool|Param, // Default: false
 *         signature?: array{
 *             algorithm?: scalar|Param|null, // The algorithm use to sign the access tokens.
 *             key?: scalar|Param|null, // The signature key. It shall be JWK encoded.
 *         },
 *         encryption?: bool|array{
 *             enabled?: bool|Param, // Default: false
 *             key_encryption_algorithm?: scalar|Param|null, // The key encryption algorithm is used to encrypt the token.
 *             content_encryption_algorithm?: scalar|Param|null, // The key encryption algorithm is used to encrypt the token.
 *             key?: scalar|Param|null, // The encryption key. It shall be JWK encoded.
 *         },
 *     },
 *     access_token_verification?: bool|array{
 *         enabled?: bool|Param, // Default: false
 *         signature?: array{
 *             header_checkers?: list<scalar|Param|null>,
 *             claim_checkers?: list<scalar|Param|null>,
 *             mandatory_claims?: list<scalar|Param|null>,
 *             allowed_algorithms?: list<scalar|Param|null>,
 *             keyset?: scalar|Param|null, // The signature keyset. It shall be JWKSet encoded.
 *         },
 *         encryption?: bool|array{
 *             enabled?: bool|Param, // Default: false
 *             continue_on_decryption_failure?: bool|Param, // If enable, non-encrypted tokens or tokens that failed during decryption or verification processes are accepted. // Default: false
 *             header_checkers?: list<scalar|Param|null>,
 *             allowed_key_encryption_algorithms?: list<scalar|Param|null>,
 *             allowed_content_encryption_algorithms?: list<scalar|Param|null>,
 *             keyset?: scalar|Param|null, // The encryption keyset. It shall be JWKSet encoded.
 *         },
 *     },
 *     blocklist_token?: bool|array{
 *         enabled?: bool|Param, // Default: false
 *         cache?: scalar|Param|null, // Storage to track blocked tokens // Default: "cache.app"
 *     },
 * }
 * @psalm-type GesdinetJwtRefreshTokenConfig = array{
 *     ttl?: int|Param, // How long a refresh token lasts, in seconds, for all authenticators. There is no value meaning never: a token is valid until this many seconds after it was issued, so a long lived one is a large number, 315360000 being ten years. // Default: 2592000
 *     max_tokens_per_user?: int|Param, // How many refresh tokens a user may hold at once. Each login stores one, so this is a limit on signed-in devices: signing in beyond it revokes the session that has gone longest without being refreshed. Unlimited when not set. // Default: null
 *     ttl_update?: bool|Param, // The default update TTL flag for all authenticators. // Default: false
 *     single_use_ttl_update?: bool|Param, // Whether a token issued in place of a single use one starts its ttl over. Turn it off to have it expire when the one it replaced would have, so that refreshing cannot be chained indefinitely. // Default: true
 *     manager_type?: scalar|Param|null, // Set the type of object manager to use (default: orm) // Default: "orm"
 *     refresh_token_class?: scalar|Param|null, // Set the refresh token class to use
 *     block_previous_jwt?: bool|Param, // Blocks the JWT a refresh replaces, when the request carried one that still parses. Needs LexikJWTAuthenticationBundle's blocklist_token turned on. A JWT that has already expired is left alone, since it is refused everywhere already. // Default: false
 *     hash_tokens?: bool|array{ // Stores the hash of a refresh token instead of the token, so a copy of the database cannot be used to refresh. Off by default.
 *         enabled?: bool|Param, // Default: false
 *         accept_stored_in_the_clear?: bool|Param, // Whether a token stored before this was turned on is still accepted, and rewritten hashed the first time it is used. Turn it off once they have all expired, so that a token read from an old backup cannot be used. // Default: true
 *     },
 *     max_session_lifetime?: int|Param, // How long a chain of refreshes may go on for, in seconds, whatever "ttl" says. A ttl that starts over on every rotation means a session can be kept alive indefinitely by using it; this is the ceiling on that. Null, the default, leaves chains unbounded. Needs a token class with families. // Default: null
 *     block_jwts_on_revocation?: bool|array{ // Refuses the JWTs already issued to a user when their refresh tokens are revoked with revokeAllForUser(). Off by default. Without it a password reset takes the refresh tokens away and leaves every JWT working until it expires.
 *         enabled?: bool|Param, // Default: false
 *         cache?: scalar|Param|null, // The PSR-6 pool the revocation marks are kept in. Read on every authenticated request, so a fast one, and shared between your processes: a local pool leaves a revoked user signed in wherever the mark did not reach. // Default: "cache.app"
 *         ttl?: int|Param, // How long a revocation mark is kept, in seconds. It only has to outlive the JWTs issued before it, so this must be at least your lexik_jwt_authentication.token_ttl. Shorter and the oldest of those tokens start being accepted again. // Default: 3600
 *         user_claim?: scalar|Param|null, // The payload claim carrying the user, which is Lexik's "user_id_claim". A payload without it is left to the rest of the verification rather than refused. // Default: "username"
 *     },
 *     rate_limiter?: bool|array{ // Bounds how often the refresh endpoint will answer. Off by default. Needs symfony/rate-limiter and a limiter configured under framework.rate_limiter.
 *         enabled?: bool|Param, // Default: false
 *         limiter?: scalar|Param|null, // The limiter service to consume from, as a service id: a limiter named "refresh" under framework.rate_limiter is the service "limiter.refresh".
 *         key?: "ip"|"token"|Param, // What the requests are counted against. "ip" protects the endpoint but makes everyone behind one address share an allowance; "token" gives each session its own, which bounds how fast a session may refresh and does nothing about a caller arriving with a different token every time. // Default: "ip"
 *     },
 *     reuse_detection?: bool|array{ // Recognises a single-use refresh token being presented after it was spent, and revokes the whole chain it belonged to. Off by default. Needs "single_use" and a token class with families.
 *         enabled?: bool|Param, // Default: false
 *         cache?: scalar|Param|null, // The PSR-6 pool the spent tokens are remembered in. Has to be shared between your processes: a local pool only catches a replay that reaches the machine which issued the token. // Default: "cache.app"
 *         ttl?: int|Param, // How long a spent token stays recognisable, in seconds. Shorter than the refresh token ttl leaves a window in which a replay looks like an ordinary wrong token, so it defaults to the same 30 days. // Default: 2592000
 *     },
 *     api_platform?: bool|array{ // Documents the refresh token in the OpenAPI specification API Platform generates. Off by default, since an application that already documents it by hand would end up with it twice.
 *         enabled?: bool|Param, // Default: false
 *     },
 *     refresh_token_manager?: scalar|Param|null, // Set your own service implementing RefreshTokenManagerInterface, storing the tokens however you like. Nothing Doctrine is wired when this is set, so the bundle works without it. Mutually exclusive with object_manager and dbal_connection. // Default: null
 *     object_manager?: scalar|Param|null, // The object manager service to store the tokens through, as a service id rather than the name an entity manager is configured under: an entity manager named "foo" is the service "doctrine.orm.foo_entity_manager". Defaults to doctrine.orm.entity_manager. Mutually exclusive with dbal_connection. // Default: null
 *     dbal_connection?: scalar|Param|null, // Set the DBAL connection to use for direct database access. Mutually exclusive with object_manager. // Default: null
 *     cache_pool?: scalar|Param|null, // Store the tokens in a PSR-6 pool instead of a database, as a service id. Expiry is then the pool's job, so nothing has to be scheduled to clear them. It cannot list or revoke a user's sessions, which rules out max_tokens_per_user, reuse detection and gesdinet:jwt:revoke. Mutually exclusive with object_manager and dbal_connection. // Default: null
 *     dbal_table_name?: scalar|Param|null, // The table name for refresh tokens when using DBAL // Default: "refresh_tokens"
 *     dbal_auto_create_table?: bool|Param, // Create the refresh tokens table on the first request when it does not exist. Off by default: it runs DDL while serving traffic, so the connection needs rights to alter the schema. Prefer a migration. // Default: false
 *     dbal_columns?: array<string, array{ // Default: []
 *         name?: scalar|Param|null, // The actual column name in the database
 *         type?: scalar|Param|null, // The DBAL type (integer, string, datetime, etc.)
 *     }>,
 *     single_use?: scalar|Param|null, // When true, generate a new refresh token on consumption (deleting the old one) // Default: false
 *     token_parameter_name?: scalar|Param|null, // The default request parameter name containing the refresh token for all authenticators. // Default: "refresh_token"
 *     cookie?: bool|array{
 *         enabled?: bool|Param, // Default: false
 *         same_site?: scalar|Param|null, // One of "none", "lax" or "strict", or empty to leave the attribute off the cookie, which is what Symfony's Cookie takes an empty value to mean. Matched without regard to case, as Cookie does. // Default: "lax"
 *         path?: scalar|Param|null, // Default: "/"
 *         domain?: scalar|Param|null, // Default: null
 *         http_only?: scalar|Param|null, // Default: true
 *         secure?: scalar|Param|null, // Default: true
 *         partitioned?: scalar|Param|null, // Default: false
 *         remove_token_from_body?: scalar|Param|null, // Default: true
 *     },
 *     return_expiration?: scalar|Param|null, // When true, the response will include the token expiration timestamp // Default: false
 *     return_expiration_parameter_name?: scalar|Param|null, // The default response parameter name containing the refresh token expiration timestamp // Default: "refresh_token_expiration"
 *     default_invalid_batch_size?: int|Param, // The default batch size when clearing invalid tokens // Default: 1000
 * }
 * @psalm-type ConfigType = array{
 *     imports?: ImportsConfig,
 *     parameters?: ParametersConfig,
 *     services?: ServicesConfig,
 *     framework?: FrameworkConfig,
 *     webpack_encore?: WebpackEncoreConfig,
 *     doctrine?: DoctrineConfig,
 *     doctrine_migrations?: DoctrineMigrationsConfig,
 *     nelmio_api_doc?: NelmioApiDocConfig,
 *     nelmio_cors?: NelmioCorsConfig,
 *     twig?: TwigConfig,
 *     stimulus?: StimulusConfig,
 *     security?: SecurityConfig,
 *     sonata_twig?: SonataTwigConfig,
 *     sonata_form?: SonataFormConfig,
 *     sonata_exporter?: SonataExporterConfig,
 *     sonata_block?: SonataBlockConfig,
 *     knp_menu?: KnpMenuConfig,
 *     sonata_admin?: SonataAdminConfig,
 *     sonata_doctrine_orm_admin?: SonataDoctrineOrmAdminConfig,
 *     sonata_translation?: SonataTranslationConfig,
 *     stof_doctrine_extensions?: StofDoctrineExtensionsConfig,
 *     monolog?: MonologConfig,
 *     fos_ck_editor?: FosCkEditorConfig,
 *     fm_elfinder?: FmElfinderConfig,
 *     flysystem?: FlysystemConfig,
 *     vich_uploader?: VichUploaderConfig,
 *     lexik_jwt_authentication?: LexikJwtAuthenticationConfig,
 *     gesdinet_jwt_refresh_token?: GesdinetJwtRefreshTokenConfig,
 *     "when@dev"?: array{
 *         imports?: ImportsConfig,
 *         parameters?: ParametersConfig,
 *         services?: ServicesConfig,
 *         framework?: FrameworkConfig,
 *         webpack_encore?: WebpackEncoreConfig,
 *         doctrine?: DoctrineConfig,
 *         doctrine_migrations?: DoctrineMigrationsConfig,
 *         nelmio_api_doc?: NelmioApiDocConfig,
 *         nelmio_cors?: NelmioCorsConfig,
 *         twig?: TwigConfig,
 *         stimulus?: StimulusConfig,
 *         security?: SecurityConfig,
 *         sonata_twig?: SonataTwigConfig,
 *         sonata_form?: SonataFormConfig,
 *         sonata_exporter?: SonataExporterConfig,
 *         sonata_block?: SonataBlockConfig,
 *         knp_menu?: KnpMenuConfig,
 *         sonata_admin?: SonataAdminConfig,
 *         sonata_doctrine_orm_admin?: SonataDoctrineOrmAdminConfig,
 *         sonata_translation?: SonataTranslationConfig,
 *         stof_doctrine_extensions?: StofDoctrineExtensionsConfig,
 *         monolog?: MonologConfig,
 *         web_profiler?: WebProfilerConfig,
 *         fos_ck_editor?: FosCkEditorConfig,
 *         fm_elfinder?: FmElfinderConfig,
 *         flysystem?: FlysystemConfig,
 *         vich_uploader?: VichUploaderConfig,
 *         maker?: MakerConfig,
 *         lexik_jwt_authentication?: LexikJwtAuthenticationConfig,
 *         gesdinet_jwt_refresh_token?: GesdinetJwtRefreshTokenConfig,
 *     },
 *     "when@prod"?: array{
 *         imports?: ImportsConfig,
 *         parameters?: ParametersConfig,
 *         services?: ServicesConfig,
 *         framework?: FrameworkConfig,
 *         webpack_encore?: WebpackEncoreConfig,
 *         doctrine?: DoctrineConfig,
 *         doctrine_migrations?: DoctrineMigrationsConfig,
 *         nelmio_api_doc?: NelmioApiDocConfig,
 *         nelmio_cors?: NelmioCorsConfig,
 *         twig?: TwigConfig,
 *         stimulus?: StimulusConfig,
 *         security?: SecurityConfig,
 *         sonata_twig?: SonataTwigConfig,
 *         sonata_form?: SonataFormConfig,
 *         sonata_exporter?: SonataExporterConfig,
 *         sonata_block?: SonataBlockConfig,
 *         knp_menu?: KnpMenuConfig,
 *         sonata_admin?: SonataAdminConfig,
 *         sonata_doctrine_orm_admin?: SonataDoctrineOrmAdminConfig,
 *         sonata_translation?: SonataTranslationConfig,
 *         stof_doctrine_extensions?: StofDoctrineExtensionsConfig,
 *         monolog?: MonologConfig,
 *         fos_ck_editor?: FosCkEditorConfig,
 *         fm_elfinder?: FmElfinderConfig,
 *         flysystem?: FlysystemConfig,
 *         vich_uploader?: VichUploaderConfig,
 *         lexik_jwt_authentication?: LexikJwtAuthenticationConfig,
 *         gesdinet_jwt_refresh_token?: GesdinetJwtRefreshTokenConfig,
 *     },
 *     "when@test"?: array{
 *         imports?: ImportsConfig,
 *         parameters?: ParametersConfig,
 *         services?: ServicesConfig,
 *         framework?: FrameworkConfig,
 *         webpack_encore?: WebpackEncoreConfig,
 *         doctrine?: DoctrineConfig,
 *         doctrine_migrations?: DoctrineMigrationsConfig,
 *         nelmio_api_doc?: NelmioApiDocConfig,
 *         nelmio_cors?: NelmioCorsConfig,
 *         twig?: TwigConfig,
 *         stimulus?: StimulusConfig,
 *         security?: SecurityConfig,
 *         sonata_twig?: SonataTwigConfig,
 *         sonata_form?: SonataFormConfig,
 *         sonata_exporter?: SonataExporterConfig,
 *         sonata_block?: SonataBlockConfig,
 *         knp_menu?: KnpMenuConfig,
 *         sonata_admin?: SonataAdminConfig,
 *         sonata_doctrine_orm_admin?: SonataDoctrineOrmAdminConfig,
 *         sonata_translation?: SonataTranslationConfig,
 *         stof_doctrine_extensions?: StofDoctrineExtensionsConfig,
 *         monolog?: MonologConfig,
 *         web_profiler?: WebProfilerConfig,
 *         fos_ck_editor?: FosCkEditorConfig,
 *         fm_elfinder?: FmElfinderConfig,
 *         flysystem?: FlysystemConfig,
 *         vich_uploader?: VichUploaderConfig,
 *         lexik_jwt_authentication?: LexikJwtAuthenticationConfig,
 *         gesdinet_jwt_refresh_token?: GesdinetJwtRefreshTokenConfig,
 *     },
 *     ...<string, ExtensionType|array{ // extra keys must follow the when@%env% pattern or match an extension alias
 *         imports?: ImportsConfig,
 *         parameters?: ParametersConfig,
 *         services?: ServicesConfig,
 *         ...<string, ExtensionType>,
 *     }>
 * }
 */
final class App
{
    /**
     * @param ConfigType $config
     *
     * @psalm-return ConfigType
     */
    public static function config(array $config): array
    {
        /** @var ConfigType $config */
        $config = AppReference::config($config);

        return $config;
    }
}

namespace Symfony\Component\Routing\Loader\Configurator;

/**
 * This class provides array-shapes for configuring the routes of an application.
 *
 * Example:
 *
 *     ```php
 *     // config/routes.php
 *     namespace Symfony\Component\Routing\Loader\Configurator;
 *
 *     return Routes::config([
 *         'controllers' => [
 *             'resource' => 'routing.controllers',
 *         ],
 *     ]);
 *     ```
 *
 * @psalm-type RouteConfig = array{
 *     path: string|array<string,string>,
 *     controller?: string,
 *     methods?: string|list<string>,
 *     requirements?: array<string,string>,
 *     defaults?: array<string,mixed>,
 *     options?: array<string,mixed>,
 *     host?: string|array<string,string>,
 *     schemes?: string|list<string>,
 *     condition?: string,
 *     locale?: string,
 *     format?: string,
 *     utf8?: bool,
 *     stateless?: bool,
 * }
 * @psalm-type ImportConfig = array{
 *     resource: string,
 *     type?: string,
 *     exclude?: string|list<string>,
 *     prefix?: string|array<string,string>,
 *     name_prefix?: string,
 *     trailing_slash_on_root?: bool,
 *     controller?: string,
 *     methods?: string|list<string>,
 *     requirements?: array<string,string>,
 *     defaults?: array<string,mixed>,
 *     options?: array<string,mixed>,
 *     host?: string|array<string,string>,
 *     schemes?: string|list<string>,
 *     condition?: string,
 *     locale?: string,
 *     format?: string,
 *     utf8?: bool,
 *     stateless?: bool,
 * }
 * @psalm-type AliasConfig = array{
 *     alias: string,
 *     deprecated?: array{package:string, version:string, message?:string},
 * }
 * @psalm-type RoutesConfig = array{
 *     "when@dev"?: array<string, RouteConfig|ImportConfig|AliasConfig>,
 *     "when@prod"?: array<string, RouteConfig|ImportConfig|AliasConfig>,
 *     "when@test"?: array<string, RouteConfig|ImportConfig|AliasConfig>,
 *     ...<string, RouteConfig|ImportConfig|AliasConfig>
 * }
 */
final class Routes
{
    /**
     * @param RoutesConfig $config
     *
     * @psalm-return RoutesConfig
     */
    public static function config(array $config): array
    {
        return $config;
    }
}
