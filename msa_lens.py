#!/bin/usr/python3
from Bio import SeqIO, AlignIO
from Bio.Data import IUPACData
import sys
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
import json

# Purpose: Generate statistics for the MSA 
# Potential Reference: https://pmc.ncbi.nlm.nih.gov/articles/PMC7671350/ (MRS from AliStat)

# Get command line parameters
if(len(sys.argv) != 3):
    print('Usage: python3 msa_lens.py filename output')
    sys.exit(-1)

fa = sys.argv[1]
out = sys.argv[2]

# Extract the data
data = SeqIO.to_dict(SeqIO.parse(fa, "fasta"))

# Protein list
proteins = IUPACData.protein_letters

# Initialize relevant variables
lengths = []
gaps = []
max_length = 0
max_length_id = None
# Reference: https://stackoverflow.com/questions/7604966/maximum-and-minimum-values-for-ints
min_length = sys.maxsize
min_length_id = None

# Calculate lengths
# Reference: https://biopython.org/docs/dev/Tutorial/chapter_msa.html
for alignment in AlignIO.parse(fa, "fasta"):
    for record in alignment:
        index1 = record.description.find('[')
        index2 = record.description.find(']')
        org = record.description[index1+1:index2]
        seq = str(record.seq).replace("-","")
        length = len(seq)
        if length > max_length:
            max_length = length
            max_length_id = org 
        if length < min_length:
            min_length = length
            min_length_id = org
        lengths.append(length)
        gaps.append(record.seq.count('-'))

avg_len = f'{sum(lengths)/len(lengths):.2f}'

# Create dictionary with values
vals = {'Average Length': avg_len, 'Max Length': max_length, 'Max Length ID': max_length_id, 'Min Length': min_length, 'Min Length ID': min_length_id}

# Print values
# Reference: https://stackoverflow.com/questions/67467383/php-parse-dict-output-from-python-scriput
print(json.dumps(vals, indent=None, separators=(',', ':')))

# Generate plot
plt.figure(figsize=(10,8))
plt.hist(lengths, color="#CD5C5C", bins=30)
plt.ylabel('Counts')
plt.xlabel('Length')
plt.title('Sequence Lengths Distribution')
# Reference: https://matplotlib.org/1.5.0/faq/howto_faq.html#save-transparent-figures
plt.savefig(out, transparent=True)
