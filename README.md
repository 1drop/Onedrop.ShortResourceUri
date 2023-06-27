# Onedrop.ShortResourceUri

This Neos package changes the default behavior of the persistent resource 
storage.
 
It will publish resources with a short uri like `/_media/alicecards.jpg` instead
of the regular `/_Resources/Persistent/0d5f77e755f664b393b62ca51a056c06f05e83c6/alicecards.jpg`.

It overrides the default publishing target for the `persistent` collection if you add the following configuration:
```yaml
Neos:
  Flow:
    resource:
      targets:
        localWebDirectoryShortUriPersistentResourcesTarget:
          target: 'Onedrop\ShortResourceUri\ResourceManagement\Target\FileSystemShortSymlinkTarget'
          targetOptions:
            baseUri: '_media/'
            path: '%FLOW_PATH_WEB%_media/'
      collections:
        persistent:
          target: 'localWebDirectoryShortUriPersistentResourcesTarget'
```

Since v1.2.0 this must be added manually and is no longer default included. This way it is possible to
for example only enable this in production context.

## Preventing duplicates

As we don't have a unique part in the published filename target, we must prevent this to happen.
Therefore a `DuplicateFilenameException` will be thrown if you try to add a duplicate filename.

This could be improved in the future.
