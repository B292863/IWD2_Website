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
if(len(sys.argv) != 3):
    print('Usage: python3 data_extractor.py family protein')
    sys.exit(-1)

# fasta = sys.argv[1]
family = sys.argv[1]
protein = sys.argv[2]

# Obtain accessions for the search term: 
# This search term ensures that the returned entries are all complete protein sequences
search_term = protein + "[Protein Name] AND " + family + "[Organism] NOT partial[Title] NOT PREDICTED[Title]"
ids = Entrez.read(Entrez.esearch(db="protein", term=search_term, retmax='50'))['IdList'] # TROUBLESHOOTING!

# Less stringent search
if len(ids) == 0:
    search_term = protein + " AND " + family + " NOT partial[Title] NOT PREDICTED[Title]"
    ids = Entrez.read(Entrez.esearch(db="protein", term=search_term, retmax='50'))['IdList']

if len(ids) == 0:
    print("EMPTY")
else:
# Return multi-line FASTA file
    for acc in ids:
        handle = Entrez.efetch(db="protein",id=acc,rettype="fasta",retmode="text")
        record = SeqIO.read(handle, "fasta")
        handle.close()

        description = record.description
        sequence = str(record.seq)
        print(">" + description)
        print(sequence)
        #outfile.write(">" + description + "\n")
        #outfile.write(sequence + "\n")
