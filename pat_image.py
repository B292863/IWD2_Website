#!/bin/usr/python3
import sys
import matplotlib.pyplot as plt
import numpy as np
# Reference: https://matplotlib.org/stable/users/explain/colors/colormaps.html
import matplotlib.cm as cm

"""
Purpose: Visualizing patmatmotifs data
"""

# Take command line parameters
if(len(sys.argv) != 3):
    print('Usage: python3 pat_image.py input_list pie_out')
    sys.exit(-1)

ins = sys.argv[1].rstrip(']').lstrip('[').split(",")
outs = sys.argv[2]

# Generating the label and counts
labs = list(set(ins))
counts = []
for label in labs:
    count = ins.count(label)
    counts.append(count)
c_array = np.array(counts)

# Creating the piechart visual
# Reference: https://www.w3schools.com/python/matplotlib_pie_charts.asp
plt.figure(figsize=(10,8))
plt.pie(c_array, labels = labs, startangle = 90, colors=plt.cm.tab20b(np.linspace(0,1,len(counts))))
plt.title("PROSITE Motif Summary")
# Refence for Matplotlib: https://matplotlib.org/stable/gallery/pie_and_polar_charts/pie_and_donut_labels.html
plt.legend(loc='center left', bbox_to_anchor=(0.8, 0, 0.6, 0))
plt.savefig(outs, transparent=True)
