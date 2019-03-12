# list.ex
defmodule ListP do
  def take(_, 0) do [] end
  def take([h | t], n) do
    [h] ++ take(t, n-1)
  end

  def drop(l, 0) do l end
  def drop([h|t], n) do
    drop(t, n-1)
  end

  def append(l, []) do l end
  def append(l, [h|t]) do
    append(l ++ [h], t)
  end

  def member([], _) do :false end
  def member([y|_], y) do :true end
  def member([h|t], y) do
    member(t, y)
  end

  def position([], y) do 0 end
  def position(l, y) do
    pos(l, y, 1)
  end

  def pos([], _, _) do 0 end
  def pos([y|_], y, i) do i end
  def pos([h|t], y, i) do
    pos(t, y, i+1)
  end
end
