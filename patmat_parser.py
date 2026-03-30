#!/bin/usr/python3
import sys
import json
import re

"""
Purpose: Patmatmotifs parser
"""

if(len(sys.argv) != 2):
    print('Usage: python3 patmat_parser.py input')
    sys.exit(-1)

ins = sys.argv[1]

infile = open(ins)
lines = infile.readlines()
residues = {}
motifs = []

for line in lines:
    line = line.rstrip()
    if "# Sequence" in line:
        sequence = line.split(" ")[2]
        residues[sequence] = {}
    if "# HitCount:" in line:
        hits = line.split(" ")[2]
        residues[sequence][hits] = []
    if "Length" in line:
        lens = line.split(" ")[2]
        residues[sequence][hits].append(lens)
    if "Start" in line:
        start = line.split(" ")[3]
        residues[sequence][hits].append(start)
    if "End" in line:
        end = line.split(" ")[3]
        residues[sequence][hits].append(end)
    if "Motif" in line:
        motif = line.split(" ")[2]
        residues[sequence][hits].append(motif)
        motifs.append(motif)
    if re.search(r'[A-Z]',line) and "#" not in line and "=" not in line:
        seqline = line
    indices = []
    if "|" in line:
        for ind in re.finditer(r'\|', line):
            indices.append(ind.start())
        ind1 = indices[0]
        ind2 = indices[1]
        motif_sequence = seqline[ind1:ind2+1]
        residues[sequence][hits].append(motif_sequence)


# Reference: https://stackoverflow.com/questions/67467383/php-parse-dict-output-from-python-scriput
print(json.dumps(residues, indent=None, separators=(',', ':')))
