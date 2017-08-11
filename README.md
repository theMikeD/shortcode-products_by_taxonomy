# ShortCode: list products by taxonomy

This is a slight modification to the built-in Woo shortcode called `product_categories`

It has been modified in two ways:
1. It takes a second arguement to specify the taxonomy to use, not just the product category;
2. the `get_terms()` call was updated to be WordPress 4.5 compliant.


## To use
Put the shortcode PHP file somewhere and reference it, or copy and paste the contents into your `functions.php` file. Then call the shortcode using `[product_by_taxonomy]` and options as described on [this page](https://docs.woocommerce.com/document/woocommerce-shortcodes/#section-12), with the additional arguement `taxonomy` to specify the taxonomy to use.


