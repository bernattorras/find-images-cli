# Search Replace URLs Plugin

This WordPress plugin searches the provided images in the wp_posts table and generates a CSV file with the URLs of all the posts that include them.

## Installation

1. Clone this repository to your WordPress plugins directory or in the mu-plugins folder.
   ```bash
   git clone https://github.com/bernattorras/find-images-cli.git

2. Activate the plugin through the WordPress admin interface if it wasn't directly cloned into the mu-plugins folder.

## Usage

### Command Line Interface (CLI)

The plugin only provides one command to specify the path of the file that has all the images.
- **wp find-images <txt_path>**
  - Specify the path to the .txt file that has all the image names

## Examples

- **wp find-images images.txt**
  - Search for the images provided in the images.txt file (which is in the same current folder).

## Result
The command generates a CSV file named `found_images.csv` in the current folder that contains a list of all the found posts posts that include these images.
