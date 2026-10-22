# Change the Loading Image

The easiest way to do this would be to override the loading image in your custom theme. You can do this as follows:

Create the following file

`app/design/frontend/[ThemeVendor]/[ThemeName]/PluginCompany_ContactForms/web/img/gears-anim.gif`

You can add a blank gif file there for example to disable the loading image completely. Alternatively you can upload another animated gif of your choice.

After creating the file you have to run the following commands for the changes to take effect:

```
bin/magento cache:clean
rm -Rf pub/static/*
bin/magento setup:static-content:deploy
```

After doing so, you might also have to clear your browser cache.

---

[Documentation index](./README.md) · [README](../README.md) · [Online version](https://plugin.company/knowledge-base/docs/magento2-custom-contact-forms/tutorials/change-the-loading-image/)
