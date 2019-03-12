# test.ex
defmodule Test do
  def product(m, n) do
    cond do
      m == 0 ->
        0
      true ->
        n + product(m - 1, n)
    end
  end

  def exp(x, n) do
    cond do
      n == 1 ->
        x
      rem(n, 2) == 0 ->
        exp(x, div(n,2)) * exp(x, div(n,2))
      true ->
        exp(x, (n - 1)) * x
    end
  end

  def len(l) do
    n = 0
    cond do
      l == [] ->
        n
      true ->
        1 + len(tl(l))
    end
  end

  def sum(l) do
    n = 0
    cond do
      l == [] ->
        n
      true ->
        hd(l) + sum(tl(l))
    end
  end

  def duplicate(l) do
    cond do
      l == [] ->
        []
      true ->
        [hd(l)] ++ [hd(l)] ++ duplicate(tl(l))
    end
  end

  def add(x, l) do
    lcopy = l
    cond do
      l == [] ->
        l ++ [x]
      x == hd(l) ->
        lcopy
      x != hd(l) ->
        [hd(l)] ++ add(x, tl(l))
    end
  end

  def remove(_, []) do [] end
  def remove(x, [x|t]) do remove(x,t) end
  def remove(x, [h|t]) do [h|remove(x,t)] end

  def unique([]) do [] end
  def unique([h|t]) do [h|unique(remove(h,t))] end

  #def pack([]) do [] end
  #def pack([h|t]) do  end

  #def match(_, []) do [] end
  #def match()

  def reverse([]) do [] end
  def reverse([h|t]) do reverse(t) ++ [h] end

  def insert(x, []) do [x] end
  def insert(x, [h|t]) when x < h do [x, h|t] end
  def insert(x, [h|t]) do [h | insert(x, t)] end

  def isort(l) do isort(l, []) end
  def isort([], l) do l end
  def isort([head | tail], sorted) do isort(tail, insert(head, sorted)) end

  def msort(l) do
    case l  do
      [] -> []
      [l] -> [l]
      l ->
        {x, y} = msplit(l, [], [])
        merge(msort(x), msort(y))
    end
  end

  def merge([], s) do s end
  def merge(l, []) do l end

  def merge([x1 | l1], [x2 | _] = l2) when x1 < x2 do
    [x1 | merge(l1, l2)]
  end

  def merge(l1,[x2|l2]) do [x2|merge(l1,l2)] end

  def msplit([], l1, l2) do {l1, l2} end
  def msplit([x | tail], l1, l2) do msplit(tail, [x | l2], l1) end

  # Quicksort
  def qsort([]) do [] end
  def qsort([p | l]) do
    {x, y} = qsplit(p, l, [], [])
    small = qsort(x)
    large = qsort(y)
    append(small, [p | large])
  end

  def qsplit(_, [], small, large) do {small,large} end
  def qsplit(p, [h | t], small, large) do
    if h < p  do
       qsplit(p, t, [h | small], large)
     else
       qsplit(p, t, small, [h | large])
     end
  end

  def append(l1, l2) do
    case l1 do
      [] -> l2
      [h | t] -> [h | append(t, l2)]
    end
  end
end
