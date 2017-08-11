# ShortCode: list products by taxonomy

This is a slight modification to the built-in Woo shortcode called `product_categories`

It has been modified in two ways:
1. It takes a second arguement to specificy the taxonomy to use, not just the product category
2. the `get_terms()` call was updated to be WordPress 4.5 compliant


## To use
Put the shortcode PHP file somewhere and reference it, or copy and paste it into your function.php file. Then call the shortcode as described on this page, with the additional arguement `taxonomy` to specify the taxonomy to use.


