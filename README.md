#twig_custom_date_range_filter#

Module adds a Custom Twig filter to show dates ranges as short as possible.

This module is not very flexible, so it is more a proof of concept.

##Example Output##

* Same Month & Year   = Aug 2-4, 2016
* Same Year           = Jul 31 - Aug 4, 2016
* Different Years     = Dec 31, 2016 - Jan 2, 2017
* No "End" Date       = Dec 31, 2016


## Installation ##

* Enable Module
* Create 2 date fields on your node "start_date" and "end_date", 1 value only.
* Update the node template
* In Twig, use node.field_start_date.value (not content.field_start_date)
* Pipe |date_range and use the node.field_start_end_date.value as the argument


## Usage ##

```Twig

<!-- node--type.html.twig -->

<h2 class="c-date">
  {{ node.field_start_date.value|date_range(node.field_end_date.value) }}
</h2>
```

## Licenced under GPL 2 ##
