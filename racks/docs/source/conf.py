# Configuration file for the Sphinx documentation builder.
#
# For the full list of built-in configuration values, see the documentation:
# https://www.sphinx-doc.org/en/master/usage/configuration.html

# -- Project information -----------------------------------------------------
# https://www.sphinx-doc.org/en/master/usage/configuration.html#project-information

import os
import sys
import django

# I've simplified this a little to use append instead of insert.
sys.path.insert(0, os.path.dirname(os.path.dirname(os.path.dirname(__file__))))

# Specify settings module
os.environ["DJANGO_SETTINGS_MODULE"] = "racks.settings"

# Setup Django
django.setup()

project = 'Racks'
copyright = '2022, 5lunk'
author = '5lunk'
release = '1.0.0'

# -- General configuration ---------------------------------------------------
# https://www.sphinx-doc.org/en/master/usage/configuration.html#general-configuration
extensions = ['sphinx.ext.autodoc']

templates_path = ['_templates']
exclude_patterns = []



# -- Options for HTML output -------------------------------------------------
# https://www.sphinx-doc.org/en/master/usage/configuration.html#options-for-html-output

html_theme = 'alabaster'
html_static_path = ['_static']
