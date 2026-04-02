#!/usr/bin/python3
from Bio import SeqIO,Entrez
import os,sys,subprocess

"""
This script is to be used for extracting the data, generally.
"""

# Setting the email
Entrez.email = "s2901468@ed.ac.uk"

# Set API key
Entrez.api_key = "5abd67ba47360369234b2deb3259b39b0308"

# Get command line parameters
if(len(sys.argv) != 3 and len(sys.argv) != 4):
    print('Usage: python3 data_extractor.py family protein stringent')
    sys.exit(-1)

family = sys.argv[1]
protein = sys.argv[2]

# Less stringent search
if len(sys.argv) == 3:
    search_term = protein + "[Protein Name] AND " + family + "[Organism] NOT partial[Title] NOT PREDICTED[Title]"
else:
    # Obtain accessions for the search term: 
    # This search term ensures that the returned entries are all complete protein sequences
     search_term = protein + " AND " + family + " NOT partial[Title] NOT PREDICTED[Title]"

# Return the top 50 matches from the search
ids = Entrez.read(Entrez.esearch(db="protein", term=search_term, retmax='50'))['IdList']

# If the search returned NO results, only print "EMPTY", which will be used to send a message to the user
if len(ids) == 0:
    print("EMPTY")
else:
# Return multi-line FASTA file
    for acc in ids:
        # Reference: https://biopython.org/docs/dev/Tutorial/chapter_seq_annot.html
        gb_handle = Entrez.efetch(db="protein",id=acc,rettype="gb",retmode="text")
        gb_record = SeqIO.read(gb_handle, "gb")
        # Close the handles
        gb_handle.close()
        
        # To more easily handle unusual/non-standard description labels, generate the fasta headers manually
        organism = gb_record.annotations['organism']
        seq_id = gb_record.id
        for feature in gb_record.features:
            if feature.type.lower() in ['protein', 'cds'] and 'product' in feature.qualifiers:
                prot = feature.qualifiers['product'][0]
        description = '>' + seq_id + ' [' + prot + '] [' + organism + '] '
        sequence = str(gb_record.seq)
        print(description)
        print(sequence)
