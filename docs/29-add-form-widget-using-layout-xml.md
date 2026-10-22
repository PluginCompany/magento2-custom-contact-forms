# Add a Form Widget Using Layout XML

In some cases you might want to add a Custom Contact Forms widget to a page by editing the corresponding layout .xml file.

This example will show you how to add a form widget to the product page by adding a custom layout.xml file to your theme.

## Step 1: Create the layout XML file in your theme folder

If it doesn't exist yet, create the following file in your theme folder:

```
app/design/frontend/<vendor>/<theme>/Magento_Catalog/layout/catalog_product_view.xml
```

The complete filename might look something like this:

```
app/design/frontend/Plugincompany/exampletheme/Magento_Catalog/layout/catalog_product_view.xml
```

## Step 2: Add the layout update XML contents

Add the following contents to the file to display the Custom Contact Form with ID 1 as a regular form:

```xml
<?xml version="1.0"?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="content">
            <block class="PluginCompany\ContactForms\Block\Form\Widget\View" name="contactForm" template="PluginCompany_ContactForms::form/widget/view.phtml">
                <action method="setFormId">
                    <argument name="form_id" xsi:type="string">1</argument>
                </action>
                <action method="setShowFormAs">
                    <argument name="show_form_as" xsi:type="string">form</argument>
                </action>
            </block>
        </referenceContainer>
    </body>
</page>
```

You can change the `form_id` parameter to the ID of the form you'd like to show. Additionally you can set the `show_form_as` parameter to either `form` or `popup`.

You're done! Clear the cache and your contact form should show up on the product page.

---

[Documentation index](./README.md) · [README](../README.md) · [Online version](https://plugin.company/knowledge-base/docs/magento2-custom-contact-forms/tutorials/add-form-widget-using-layout-xml/)
