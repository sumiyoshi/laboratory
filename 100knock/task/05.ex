# 05. n-gram

str = "I am an NLPer"
IO.inspect(Ngram.bi_ngram str)
IO.inspect(Ngram.bi_ngram String.split str)