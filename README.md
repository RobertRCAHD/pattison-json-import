# pattison-json-import
## Overview
- The code for my Pattison Food Group skills test, by Robert Collins.
- **Once installed, access the importer by clicking 'JSON Importer' from the menu in the WordPress Dashboard, or the 'Settings' link on the Plugin. [Screengrab](https://share.zight.com/p9uB4z7Z)**

## Features
- Import the JSON from the remote URL (https://jsonplaceholder.org/posts) with a single click.
- The JSON data is stored as regular Posts.
- No duplicate posts - the Plugin checks if a to-be-imported Post is a duplicate and skips any duplicate Posts.
- CTA ("Call to Action") is appended to all individual/single Posts.
- The Plugin works with any WordPress Theme. It was tested on 'Twenty Twenty-Four'.
- Security: Sanitizes the JSON when importing so executable code cannot be imported.
- Security: Prevents access to directory listings.
- Security: Leverages Nonce to thwart CSRF attacks.

### Notes
- The Plugin uses the default styling/design of the Theme to render on the frontend.
- The posts will show as a list or individually depending on the Theme context. For example, on Twenty Twenty-Four if you scroll down to where 'Recent Posts' are listed, you will see the Posts listed. If you click on a Post, you will see the individual Posts. [Quick Gif of this in action on Twenty Twenty-Four](https://share.zight.com/2Nu9QAop). Be sure to checkout the 'Call to Action' (CTA) on an individual Post.
- Anything can be made "editable", like the JSON URL, the CTA text, button color, button target, etc, but I had to stop somewhere :)
- Pagination is available if the Theme paginates Posts.

### The instructions from Pattison were:
Code a custom WordPress plugin that pulls posts from this example API endpoint and renders the list on the front end of a WordPress page or post: https://jsonplaceholder.org/posts
• Bonus points for rendering these with a nice design on the frontend, caching or storing the post data, allowing rendering of the individual posts, including strong calls to action and other features like pagination
• Code should be uploaded to a public github repository, and a link shared back for us to review

## How to Install
- Simply "Download ZIP" by clicking the green "Code" button here in GitHub, then upload the .zip and activate normally in the WordPress Dashboard (/wp-admin/).
