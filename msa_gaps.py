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
    print('Usage: python3 msa_gaps.py filename output')
    sys.exit(-1)

fa = sys.argv[1]
out = sys.argv[2]

# Extract the data
data = SeqIO.to_dict(SeqIO.parse(fa, "fasta"))

# Protein list
proteins = IUPACData.protein_letters

gaps = []
max_gaps = 0
max_gap_id = None
# Reference: https://stackoverflow.com/questions/7604966/maximum-and-minimum-values-for-ints
min_gaps = sys.maxsize
min_gap_id = None


# Reference: https://biopython.org/docs/dev/Tutorial/chapter_msa.html
for alignment in AlignIO.parse(fa, "fasta"):
    #print("Alignment length %i" % alignment.get_alignment_length())
    for record in alignment:
        index1 = record.description.find('[')
        index2 = record.description.find(']')
        org = record.description[index1+1:index2]
        gap = record.seq.count('-')
        if gap > max_gaps:
            max_gaps = gap
            max_gap_id = org 
        if gap < min_gaps:
            min_gaps = gap
            min_gap_id = org
        gaps.append(gap)

avg_gap = f'{sum(gaps)/len(gaps):.2f}'

gap_vals = {'Average Number of Gaps': avg_gap, 'Max Number of Gaps': max_gaps, 'Max Gaps ID': max_gap_id, 'Min Number of Gaps': min_gaps, 'Min Gaps ID': min_gap_id}

# Reference: https://stackoverflow.com/questions/67467383/php-parse-dict-output-from-python-scriput
print(json.dumps(gap_vals, indent=None, separators=(',', ':')))

plt.figure(figsize=(10,8))
plt.hist(gaps, color="#CD5C5C", bins=30)
plt.ylabel('Counts')
plt.xlabel('Number of Gaps')
plt.title('Gap Composition Distribution')
# Reference: https://matplotlib.org/1.5.0/faq/howto_faq.html#save-transparent-figures
plt.savefig(out, transparent=True)
