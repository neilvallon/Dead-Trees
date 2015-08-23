#!/usr/bin/env python
# coding: utf-8
import os, time
from random import *

class Rain():
	def __init__(self, x, y):
		self.x = x
		self.y = y
		self.typeMatrix = self.uniformMatrix('0')
		self.charMatrix = self.uniformMatrix(' ')
	
	def randomUnicode(self):
		return unichr(randrange(0x30A1, 0x30FA))

	def randSign(self):
		r = random()
		if r <= .20:
			return -1
		elif r <= .25:
			return 1
		return 0
	
	def uniformMatrix(self, val=''):
		return [[val]*self.x for y in xrange(self.y)]
	
	def mapMatrix(self, fun):
		ret = self.uniformMatrix()
		for y in xrange(self.y):
			for x in xrange(self.x):
				ret[y][x] = fun(x, y)
		return ret
	
	def updateTypeRow(self):
		newRow = [self.randSign() for x in xrange(self.x)]
		self.typeMatrix.pop()
		self.typeMatrix.insert(0, newRow)
		return self
	
	def updateCharMatrix(self):
		def setChar(x, y):
			if self.typeMatrix[y][x] == -1:
				return ' '
			elif self.typeMatrix[y][x] == 1:
				return self.randomUnicode()
			else:
				return self.charMatrix[y][x]
		self.charMatrix = self.mapMatrix(setChar)
		return self
	
	def colorMatrix(self):
		def colorize(x, y):
			if self.typeMatrix[y][x] == 1:
				return '\033[40;37m' + self.charMatrix[y][x]
			else:
				return '\033[40;32m' + self.charMatrix[y][x]
		return self.mapMatrix(colorize)
	
	def printNext(self):
		self.updateTypeRow().updateCharMatrix()
		for y in self.colorMatrix():
			print '\t'.join(y)


#######################
m = Rain(10, 30)
sleepTime = 0.1
#######################

while(1):
	os.system('clear')
	m.printNext()
	time.sleep(sleepTime)
