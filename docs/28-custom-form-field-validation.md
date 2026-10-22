# Custom Form Field Validation

The instructions below will show you how to add a custom form field Javascript validation rule to a Custom Contact Form.

In this example we'll add a rule which excludes all non-latin characters in the message field of a form, which was requested by one of our clients.

## Steps to add custom form field validation

First add the Custom CSS Class `only-latin-characters` to the message field on the form builder. We'll refer to this class name in the following step.

Go to the edit form page in the admin area and add the following code to the `Custom Javascript > Arbitrary JS - on page load` field:

```js
jQuery.validator.addMethod(
           "only-latin-characters",
           function(value, element) {
               return jQuery.mage.isEmptyNoTrim(value) || !/[^\x00-\x7F]/.test(value);
           },
           jQuery.mage.__("Please use only latin characters in this field.")
       );
jQuery('.only-latin-characters .form-control').addClass('only-latin-characters');
```

- The regex that tests the entered value is `!/[^\x00-\x7F]/`
- The form field class name is `only-latin-characters`
- The error message to be displayed is `Please use only latin characters in this field.`

####

---

[Documentation index](./README.md) · [README](../README.md) · [Online version](https://plugin.company/knowledge-base/docs/magento2-custom-contact-forms/tutorials/custom-form-field-validation/)
