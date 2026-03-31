#!/usr/bin/python3
from Bio import Phylo
import matplotlib.pyplot as plt
import matplotlib
import os,sys

"""
Purpose: Create Gene Tree
"""

# Take command line parameters
if(len(sys.argv) != 3):
    print('Usage: python3 phylo_tree.py treefile output')
    sys.exit(-1)

treefile = sys.argv[1]
output = sys.argv[2]

# Take input in tree format
# References: https://stackoverflow.com/questions/29419973/in-python-how-can-i-change-the-font-size-of-leaf-nodes-when-generating-phylogen
tree = Phylo.read(treefile, "newick")

# Set the font size
matplotlib.rc('font', size=5)

# References: https://biopython.org/docs/1.75/api/Bio.Phylo.BaseTree.html
for clade in tree.find_clades():
    if clade.is_terminal() and hasattr(clade, "label"):
        clade.label_font_size = 10

# Generate and save phylogenetic tree
Phylo.draw(tree)
plt.title('Phylogenetic Tree')
plt.savefig(output, transparent=True)
plt.close()
