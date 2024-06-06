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
* Jetpack Plugin to Render proper markupp

## Steps to configure this plugin in your site:

#### Activate jetpack's markdown for comments settings.

![Activate jetpack markdown for comment setting](https://user-images.githubusercontent.com/25550562/180242598-8b6fe11a-6864-41b1-9663-ea7302945a36.png)


#### Activate comment preview plugin.

![Activate comment preview plugin](https://user-images.githubusercontent.com/25550562/180242868-dc262684-8151-456c-9944-a62550164044.png)

#### Comment form.

![Comment's form and preview of comment](https://user-images.githubusercontent.com/25550562/180243187-f2960ce6-7347-4c8b-9c40-563e51e77aca.png)


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

Or

If you have WordPress boilerplate with Composer, just add this to repository object and inside the require dependency.

```bash
"repositories": [
	{
		"type": "vcs",
		"url": "git@github.com:kishanjasani/comment-preview.git"
	}
]

"require": {
	"kishanjasani/comment-preview": "dev-main"
}
```

And run this composer command in terminal

```bash
composer update
```

Now, you should see plugin on the plugin page in WordPress dashboard.

## Unit Test
To run unit test you need to manually clone the repo inside the plugin directory and run these commands.

```bash
composer install

./vendor/bin/phpunit
```

Happy Coding!😊
