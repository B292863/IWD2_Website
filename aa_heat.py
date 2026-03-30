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
# Potential Reference: https://pmc.ncbi.nlm.nih.gov/articles/PMC7671350/ (MRS from AliStat)

# Get command line parameters
if(len(sys.argv) != 3):
    print('Usage: python3 msa_stats.py filename heatmap_output')
    sys.exit(-1)

fa = sys.argv[1]
heat = sys.argv[2]

# Protein list
proteins = IUPACData.protein_letters

# Reference: https://biopython.org/docs/dev/Tutorial/chapter_msa.html
for alignment in AlignIO.parse(fa, "fasta"):
    # Troubleshooting: print("hello")
    # Find Substitutions
    subs = alignment.substitutions
    # Troubleshooting: print(subs)
    subs = subs.select(proteins)
    #avg = np.median(subs,axis=None)

    # Generate Heatmap
    plt.figure(figsize=(17,15))
    matplotlib.rcParams['savefig.transparent'] = True
    sns.heatmap(subs, annot=True, fmt='.0f', cmap='coolwarm', xticklabels=proteins, yticklabels=proteins)
    plt.xlabel('Amino Acids')
    plt.ylabel('Amino Acids')
    plt.savefig(heat)
    # Troubleshooting: print('generated')
