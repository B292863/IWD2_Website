#!/usr/bin/pythoni3
from Bio import SeqIO, AlignIO
from Bio.Data import IUPACData
import sys
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
from matplotlib import rc
import matplotlib

# Purpose: Generate statistics for the MSA 

# Get command line parameters
if(len(sys.argv) != 3):
    print('Usage: python3 msa_stats.py filename heatmap_output')
    sys.exit(-1)

# Set command line parameters as variables
fa = sys.argv[1]
heat = sys.argv[2]

# Protein list
proteins = IUPACData.protein_letters

# Reference: https://biopython.org/docs/dev/Tutorial/chapter_msa.html
for alignment in AlignIO.parse(fa, "fasta"):
    # Find Substitutions
    subs = alignment.substitutions
    subs = subs.select(proteins)

    # Generate Heatmap
    plt.figure(figsize=(17,15))
    matplotlib.rcParams['savefig.transparent'] = True
    sns.heatmap(subs, annot=True, fmt='.0f', cmap='coolwarm', xticklabels=proteins, yticklabels=proteins)
    plt.title('Amino Acid Substitutions')
    plt.xlabel('Amino Acids')
    plt.ylabel('Amino Acids')
    plt.savefig(heat)
