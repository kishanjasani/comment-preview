# Comment Preview
The plugin will show real comment previews to the users

-------------------

## Maintainer

| Name                                                   | Github Username |
|--------------------------------------------------------|-----------------|
| [Kishan Jasani](mailto:kishanjasani007@yahoo.in)       |  @kishanjasani   |


## Requirements

* PHP Requires: 7.0
* WordPress Requires at least: 4.7

## Steps to configure this plugin in your site:

#### Activate jetpack's markdown for comments settings.

![Activate jetpack markdown for comment setting](https://prnt.sc/2ZppEqH6Z6UH)

#### Activate comment preview plugin.
![Activate comment preview plugin](https://prnt.sc/1EiIah7z-389)

#### Comment form.

![Comment's form and preview of comment](https://prnt.sc/5pAJYHEnaO_p)

## Want to add markdown support for your custom post type?
You can use `comment_preview_allowed_post_types` filter to add ustom post type support.

Ex:
```
add_filter( 'comment_preview_allowed_post_types', function( $post_type ) {
	return $post_type[] = 'new_post_type';
} );
```

**NOTE:** `This plugin works with WordPress's default comment form only.`

## Available Endpoint

**Convert Markdown comment to readable format ( POST request )**
- `http://example.com/wp-json/comment_preview/v1/preview`
	- Params:
		- `comment` - Comment text.
		- `format` - Whether to preview markdown or plain text - Two values it will take `plain` OR `markdown`.
		- `author` - For non-logged in user you can send author's name here, logged-in users will automatically get their name in that comment.

## Contributing

**During development**

Clone the repo and run
```bash
cd comment-preview
composer install
composer dump-autoload
```
