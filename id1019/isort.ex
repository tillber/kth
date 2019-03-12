# isort.ex
def insert(x, []) do [x] end
def insert(x, [h|t]) when x < h do [x, h|t] end
def insert(x, [h|t]) do [h | insert(x, t)] end

def isort(l) do isort(l, []) end
def isort([], l) do l end
def isort([head | tail], sorted) do isort(tail, insert(head, sorted)) end
